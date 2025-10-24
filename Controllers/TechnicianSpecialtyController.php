<?php
class TechnicianSpecialty
{
    public function index()
    {
        try {
            $response = new Response();
            $technicianSpecialty = new TechnicianSpecialtyModel();
            $result = $technicianSpecialty->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTechnician($technician_id)
    {
        try {
            $response = new Response();
            $technicianSpecialty = new TechnicianSpecialtyModel();
            $result = $technicianSpecialty->getByTechnician($technician_id);
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
            $technicianSpecialty = new TechnicianSpecialtyModel();
            $result = $technicianSpecialty->create($inputJSON);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}