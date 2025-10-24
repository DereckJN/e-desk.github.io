<?php
class AssessmentModel
{
    public $enlace;
    public function __construct()
    {

        $this->enlace = new MySqlConnect();
    }
    public function all()
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM valoracion;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id_valoracion)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM valoracion where id_valoracion=$id_valoracion";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            return $vResultado[0];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
  
}
