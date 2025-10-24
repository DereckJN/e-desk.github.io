<?php
class TicketStatusModel
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
            $vSql = "SELECT * FROM estado_ticket;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id_estado)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM estado_ticket where id_estado=$id_estado";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            return $vResultado[0];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
  
}
