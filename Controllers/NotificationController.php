<?php
//class Genre
class notificacion{
    //Listar en el API
    public function index(){
        $response = new Response();
        //Obtener el listado del Modelo
        $notificacion=new NotificationModel();
        $result=$notificacion->all();
         //Dar respuesta
         $response->toJSON($result);
    }
    public function get($param){
        $response = new Response();
        $notificacion=new NotificationModel();
        $result=$notificacion->get($param);
        //Dar respuesta
        $response->toJSON($result);
    }
   
}