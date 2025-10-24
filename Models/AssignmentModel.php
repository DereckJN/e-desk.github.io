<?php
class AssignmentModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT a.*, t.title as ticket_title, u.email as technician_email 
                     FROM assignment a 
                     INNER JOIN ticket t ON a.ticket_id = t.ticket_id 
                     INNER JOIN user u ON a.technician_id = u.user_id
                     ORDER BY a.assignment_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($id)
    {
        try {
            $sql = "SELECT a.*, t.title as ticket_title, u.email as technician_email 
                     FROM assignment a 
                     INNER JOIN ticket t ON a.ticket_id = t.ticket_id 
                     INNER JOIN user u ON a.technician_id = u.user_id 
                     WHERE a.assignment_id = $id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result[0];
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTicket($ticket_id)
    {
        try {
            $sql = "SELECT a.*, u.email as technician_email 
                     FROM assignment a 
                     INNER JOIN user u ON a.technician_id = u.user_id 
                     WHERE a.ticket_id = $ticket_id
                     ORDER BY a.assignment_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTechnician($technician_id)
    {
        try {
            $sql = "SELECT a.*, t.title as ticket_title, t.status_id
                     FROM assignment a 
                     INNER JOIN ticket t ON a.ticket_id = t.ticket_id 
                     WHERE a.technician_id = $technician_id
                     ORDER BY a.assignment_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getAssignedTickets($technician_id)
    {
        try {
            $sql = "SELECT t.*, st.status_name, c.category_name
                     FROM ticket t 
                     INNER JOIN ticket_status st ON t.status_id = st.status_id 
                     INNER JOIN category c ON t.category_id = c.category_id 
                     INNER JOIN assignment a ON t.ticket_id = a.ticket_id
                     WHERE a.technician_id = $technician_id
                     ORDER BY t.creation_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create($object)
    {
        try {
            $sql = "INSERT INTO assignment (ticket_id, technician_id, assignment_method) 
                     VALUES ($object->ticket_id, $object->technician_id, '$object->assignment_method')";
            
            $result = $this->connection->executeSQL_DML_last($sql);
            
            // Update technician's load
            $technicianModel = new TechnicianModel();
            $technicianModel->updateLoad($object->technician_id);
            
            return $this->get($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}