<?php
// controllers/RoutesController.php
class RoutesController
{
    private $authMiddleware;       // opcional
    private $protectedRoutes = []; // prefijos protegidos
    private $API_PREFIX = '/e-desk/api';
    private $UPLOADS_PREFIX = '/e-desk/uploads';

    public function __construct() {
        // $this->authMiddleware = new AuthMiddleware();
        $this->registerRoutes();
    }

    private function registerRoutes() {
        // Protege prefijos (coinciden por prefijo, no por ruta exacta)
        $this->addProtectedRoute('GET',    "{$this->API_PREFIX}/ticket",     ['Administrador','Agente','Supervisor']);
        $this->addProtectedRoute('POST',   "{$this->API_PREFIX}/ticket",     ['Administrador','Agente']);
        $this->addProtectedRoute('PUT',    "{$this->API_PREFIX}/ticket",     ['Administrador','Agente']);
        $this->addProtectedRoute('PATCH',  "{$this->API_PREFIX}/ticket",     ['Administrador','Agente']);
        $this->addProtectedRoute('DELETE', "{$this->API_PREFIX}/ticket",     ['Administrador']);

        $this->addProtectedRoute('GET',    "{$this->API_PREFIX}/technician", ['Administrador','Agente','Supervisor']);
        $this->addProtectedRoute('POST',   "{$this->API_PREFIX}/technician", ['Administrador']);
        $this->addProtectedRoute('PUT',    "{$this->API_PREFIX}/technician", ['Administrador']);
        $this->addProtectedRoute('PATCH',  "{$this->API_PREFIX}/technician", ['Administrador']);
        $this->addProtectedRoute('DELETE', "{$this->API_PREFIX}/technician", ['Administrador']);

        $this->addProtectedRoute('GET',    "{$this->API_PREFIX}/category",   ['Administrador','Agente','Supervisor']);
        $this->addProtectedRoute('POST',   "{$this->API_PREFIX}/category",   ['Administrador']);
        $this->addProtectedRoute('PUT',    "{$this->API_PREFIX}/category",   ['Administrador']);
        $this->addProtectedRoute('PATCH',  "{$this->API_PREFIX}/category",   ['Administrador']);
        $this->addProtectedRoute('DELETE', "{$this->API_PREFIX}/category",   ['Administrador']);

        // Endpoints públicos (no los registres aquí): health, login, etc.
    }

    public function index()
    {
        // CORS básico
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

        // OPTIONS preflight
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        // Entrega de archivos /uploads
        $rawUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path   = parse_url($rawUri, PHP_URL_PATH) ?: '/';
        if (strpos($path, $this->UPLOADS_PREFIX . '/') === 0) {
            $filePath = __DIR__ . '/..' . $path; // ajusta si tu uploads vive en otra ruta
            if (file_exists($filePath)) {
                header('Content-Type', mime_content_type($filePath));
                readfile($filePath);
                exit;
            }
            http_response_code(404);
            echo 'Archivo no encontrado.';
            return;
        }

        // Autenticación por prefijo protegido
        $method = $_SERVER['REQUEST_METHOD'];
        if ($this->isProtectedRoute($method, $path)) {
            $route = $this->getProtectedRoute($method, $path);
            if (!isset($this->authMiddleware)) {
                http_response_code(401);
                echo json_encode(['status'=>401,'result'=>'AuthMiddleware no configurado']);
                return;
            }
            if (!$this->authMiddleware->handle($route['roles'])) {
                http_response_code(403);
                echo json_encode(['status'=>403,'result'=>'No autorizado']);
                return;
            }
        }

        // Dispatch a controladores
        $this->dispatch($path, $method);
    }

    private function dispatch(string $path, string $method)
    {
        $segments = array_values(array_filter(explode('/', strtolower($path))));
        // Espera /e-desk/api/{controller}/{action?}/{param1?}/{param2?}
        if (count($segments) < 3 || $segments[0] !== 'e-desk' || $segments[1] !== 'api') {
            return $this->jsonError(404, 'Ruta base inválida. Use /e-desk/api/{controller}');
        }

        $controllerSlug = $segments[2] ?? null; // ticket | technician | category | user | health
        $action = $segments[3] ?? null;
        $param1 = $segments[4] ?? null;
        $param2 = $segments[5] ?? null;

        if (!$controllerSlug) return $this->jsonError(404, 'Controlador no especificado');

        $className = $controllerSlug; // o ucfirst($controllerSlug).'Controller' si tus clases tienen sufijo

        if (!class_exists($className)) return $this->jsonError(404, 'Controlador no encontrado');

        try {
            $controller = new $className();

            switch ($method) {
                case 'GET':
                    if ($param1 && $param2 && $action && method_exists($controller, $action)) return $controller->$action($param1, $param2);
                    if ($param1 && !$action && method_exists($controller, 'get'))        return $controller->get($param1);
                    if ($param1 && $action && method_exists($controller, $action))      return $controller->$action($param1);
                    if (!$action && method_exists($controller, 'index'))                 return $controller->index();
                    if ($action) {
                        if (method_exists($controller, $action))                         return $controller->$action();
                        if (count($segments) === 4 && method_exists($controller, 'get')) return $controller->get($action);
                        return $this->jsonError(404, 'Acción no encontrada');
                    }
                    return $this->jsonError(404, 'Acción no encontrada');

                case 'POST':
                    if ($action) {
                        if (method_exists($controller, $action)) return $controller->$action();
                        return $this->jsonError(404, 'Acción no encontrada');
                    }
                    if (method_exists($controller, 'create')) return $controller->create();
                    return $this->jsonError(404, 'Acción no encontrada');

                case 'PUT':
                case 'PATCH':
                    if ($param1 && method_exists($controller, 'update')) return $controller->update($param1);
                    if ($action && method_exists($controller, $action))   return $controller->$action();
                    if (method_exists($controller, 'update'))             return $controller->update();
                    return $this->jsonError(404, 'Acción no encontrada');

                case 'DELETE':
                    if ($param1 && method_exists($controller, 'delete')) return $controller->delete($param1);
                    if ($action && method_exists($controller, $action))  return $controller->$action();
                    if (method_exists($controller, 'delete'))            return $controller->delete();
                    return $this->jsonError(404, 'Acción no encontrada');

                default:
                    return $this->jsonError(405, 'Método HTTP no permitido');
            }
        } catch (\Throwable $th) {
            return $this->jsonError(500, $th->getMessage());
        }
    }

    private function addProtectedRoute(string $method, string $prefix, array $roles) {
        $this->protectedRoutes[] = [
            'method' => strtoupper($method),
            'prefix' => rtrim($prefix, '/'),
            'roles'  => $roles
        ];
    }
    private function isProtectedRoute(string $method, string $path): bool {
        $method = strtoupper($method);
        foreach ($this->protectedRoutes as $r) {
            if ($r['method'] === $method && strpos($path, $r['prefix']) === 0) return true;
        }
        return false;
    }
    private function getProtectedRoute(string $method, string $path): ?array {
        $method = strtoupper($method);
        foreach ($this->protectedRoutes as $r) {
            if ($r['method'] === $method && strpos($path, $r['prefix']) === 0) return $r;
        }
        return null;
    }
    private function jsonError(int $code, string $message) {
        http_response_code($code);
        echo json_encode(['status'=>$code, 'result'=>$message]);
    }
}
