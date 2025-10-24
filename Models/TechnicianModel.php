<?php
class TechnicianModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT t.*, u.email, u.status 
                     FROM technician t 
                     INNER JOIN user u ON t.user_id = u.user_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            
            if(!empty($result) && is_array($result)){
                for ($i=0; $i <= count($result)-1; $i++) { 
                    $result[$i] = $this->get($result[$i]->user_id);
                }
            }
            
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($id)
    {
        $result = null;
        try {
            $specialtyModel = new TechnicianSpecialtyModel();
            
            $sql = "SELECT t.*, u.email, u.status 
                     FROM technician t 
                     INNER JOIN user u ON t.user_id = u.user_id 
                     WHERE t.user_id = $id";
            
            $result = $this->connection->ExecuteSQL($sql);
            
            if (!empty($result)) {
                $result = $result[0];
                $result->specialties = $specialtyModel->getByTechnician($id);
            }
            
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getAvailableTechnicians()
    {
        try {
            $sql = "SELECT t.*, u.email 
                     FROM technician t 
                     INNER JOIN user u ON t.user_id = u.user_id 
                     WHERE t.availability = 'Available' 
                     AND t.current_load < t.max_load 
                     AND t.status = 1";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getBySpecialty($specialty_id)
    {
        try {
            $sql = "SELECT t.*, u.email 
                     FROM technician t 
                     INNER JOIN user u ON t.user_id = u.user_id 
                     INNER JOIN technician_specialty ts ON t.user_id = ts.technician_id 
                     WHERE ts.specialty_id = $specialty_id 
                     AND t.status = 1";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function updateLoad($technician_id)
    {
        try {
            $sql = "UPDATE technician 
                     SET current_load = active_tickets,
                         load_update_date = NOW()
                     WHERE user_id = $technician_id";
            
            $result = $this->connection->executeSQL_DML($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}