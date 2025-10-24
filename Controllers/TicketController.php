<?php
class Ticket
{
    public function index()
    {
        try {
            $response = new Response();
            $ticket = new TicketModel();
            $result = $ticket->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $ticket = new TicketModel();
            $result = $ticket->get($param);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByUser($user_id)
    {
        try {
            $response = new Response();
            $ticket = new TicketModel();
            $result = $ticket->getByUser($user_id);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByStatus($status_id)
    {
        try {
            $response = new Response();
            $ticket = new TicketModel();
            $result = $ticket->getByStatus($status_id);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create()
    {
        try {
            $request = new Request();
            $response = new Response();
            $inputJSON = $request->getJSON();
            $ticket = new TicketModel();
            $result = $ticket->create($inputJSON);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function update()
    {
        try {
            $request = new Request();
            $response = new Response();
            $inputJSON = $request->getJSON();
            $ticket = new TicketModel();
            $result = $ticket->update($inputJSON);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}