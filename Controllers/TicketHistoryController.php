<?php
//class 
class TicketHistoryModel{
    //Listar en el API
    public function index(){
        $response = new Response();
        //Obtener el listado del Modelo
        $historial_ticket=new TicketHistoryModel();
        $result=$historial_ticket->all();
         //Dar respuesta
         $response->toJSON($result);
    }
    public function get($param){
        $response = new Response();
        $historial_ticket=new TicketHistoryModel();
        $result=$historial_ticket->get($param);
        //Dar respuesta
        $response->toJSON($result);
    }
   
}