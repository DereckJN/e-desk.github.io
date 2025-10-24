<?php
class TechnicianSpecialtyModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT ts.*, u.email as technician_email, s.specialty_name 
                     FROM technician_specialty ts 
                     INNER JOIN user u ON ts.technician_id = u.user_id 
                     INNER JOIN specialty s ON ts.specialty_id = s.specialty_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTechnician($technician_id)
    {
        try {
            $sql = "SELECT ts.*, s.specialty_name, s.status as specialty_status
                     FROM technician_specialty ts 
                     INNER JOIN specialty s ON ts.specialty_id = s.specialty_id 
                     WHERE ts.technician_id = $technician_id
                     AND s.status = 'Active'";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getBySpecialty($specialty_id)
    {
        try {
            $sql = "SELECT ts.*, u.email as technician_email
                     FROM technician_specialty ts 
                     INNER JOIN user u ON ts.technician_id = u.user_id 
                     WHERE ts.specialty_id = $specialty_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function addSpecialtyToTechnician($technician_id, $specialty_id)
    {
        try {
            $sql = "INSERT INTO technician_specialty (technician_id, specialty_id) 
                     VALUES ($technician_id, $specialty_id)";
            
            $result = $this->connection->executeSQL_DML($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create($object)
    {
        try {
            $sql = "INSERT INTO technician_specialty (technician_id, specialty_id) 
                     VALUES ($object->technician_id, $object->specialty_id)";
            
            $result = $this->connection->executeSQL_DML($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}