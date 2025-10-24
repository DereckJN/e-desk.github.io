<?php
class TicketHistoryModel
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
            $vSql = "SELECT * FROM historial_Tickets;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id_historial)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM historial_Tickets where id_historial=$id_historial";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            return $vResultado[0];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
  
}
