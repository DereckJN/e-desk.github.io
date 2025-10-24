<?php
class Assignment
{
    public function index()
    {
        try {
            $response = new Response();
            $assignment = new AssignmentModel();
            $result = $assignment->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $assignment = new AssignmentModel();
            $result = $assignment->get($param);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTicket($ticket_id)
    {
        try {
            $response = new Response();
            $assignment = new AssignmentModel();
            $result = $assignment->getByTicket($ticket_id);
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
            $assignment = new AssignmentModel();
            $result = $assignment->create($inputJSON);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}