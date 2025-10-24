<?php
class SLA
{
    public function index()
    {
        try {
            $response = new Response();
            $sla = new SLAModel();
            $result = $sla->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $sla = new SLAModel();
            $result = $sla->get($param);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getActiveSLAs()
    {
        try {
            $response = new Response();
            $sla = new SLAModel();
            $result = $sla->getActiveSLAs();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}