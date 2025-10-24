<?php
class especialidad
{
    public function index()
    {
        try {
            $response = new Response();
            //Obtener el listado del Modelo
            $especialidad = new SpecialtyModel();
            $result = $especialidad->all();
            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
    public function get($param)
    {
        try {
            $response = new Response();
            $especialidad = new SpecialtyModel();
            $result = $especialidad->get($param);
            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
