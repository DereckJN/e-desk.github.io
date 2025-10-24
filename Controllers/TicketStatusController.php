<?php
//class 
class TicketStatusModel{
    //Listar en el API
    public function index(){
        $response = new Response();
        //Obtener el listado del Modelo
        $estado_ticket=new TicketStatusModel();
        $result=$estado_ticket->all();
         //Dar respuesta
         $response->toJSON($result);
    }
    public function get($param){
        $response = new Response();
        $estado_ticket=new TicketStatusModel();
        $result=$estado_ticket->get($param);
        //Dar respuesta
        $response->toJSON($result);
    }
   
}