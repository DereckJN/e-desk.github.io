<?php
class StatusHistory
{
    public function index()
    {
        try {
            $response = new Response();
            $statusHistory = new StatusHistoryModel();
            $result = $statusHistory->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $statusHistory = new StatusHistoryModel();
            $result = $statusHistory->get($param);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTicket($ticket_id)
    {
        try {
            $response = new Response();
            $statusHistory = new StatusHistoryModel();
            $result = $statusHistory->getByTicket($ticket_id);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}