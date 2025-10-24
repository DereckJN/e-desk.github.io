<?php
class Technician
{
    public function index()
    {
        try {
            $response = new Response();
            $technician = new TechnicianModel();
            $result = $technician->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $technician = new TechnicianModel();
            $result = $technician->get($param);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getAvailableTechnicians()
    {
        try {
            $response = new Response();
            $technician = new TechnicianModel();
            $result = $technician->getAvailableTechnicians();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getBySpecialty($specialty_id)
    {
        try {
            $response = new Response();
            $technician = new TechnicianModel();
            $result = $technician->getBySpecialty($specialty_id);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}