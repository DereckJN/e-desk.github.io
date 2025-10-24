<?php
class TicketModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT t.*, st.status_name, c.category_name, u.email as client_email 
                     FROM ticket t 
                     INNER JOIN ticket_status st ON t.status_id = st.status_id 
                     INNER JOIN category c ON t.category_id = c.category_id 
                     INNER JOIN user u ON t.client_user_id = u.user_id
                     ORDER BY t.creation_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            
            if(!empty($result) && is_array($result)){
                for ($i=0; $i <= count($result)-1; $i++) { 
                    $result[$i] = $this->get($result[$i]->ticket_id);
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
            $assignmentModel = new AssignmentModel();
            $statusHistoryModel = new StatusHistoryModel();
            
            $sql = "SELECT t.*, st.status_name, c.category_name, u.email as client_email 
                     FROM ticket t 
                     INNER JOIN ticket_status st ON t.status_id = st.status_id 
                     INNER JOIN category c ON t.category_id = c.category_id 
                     INNER JOIN user u ON t.client_user_id = u.user_id 
                     WHERE t.ticket_id = $id";
            
            $result = $this->connection->ExecuteSQL($sql);
            
            if (!empty($result)) {
                $result = $result[0];
                // Get ticket assignments
                $result->assignments = $assignmentModel->getByTicket($id);
                // Get status history
                $result->status_history = $statusHistoryModel->getByTicket($id);
            }
            
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByUser($user_id)
    {
        try {
            $sql = "SELECT t.*, st.status_name, c.category_name 
                     FROM ticket t 
                     INNER JOIN ticket_status st ON t.status_id = st.status_id 
                     INNER JOIN category c ON t.category_id = c.category_id 
                     WHERE t.client_user_id = $user_id
                     ORDER BY t.creation_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByStatus($status_id)
    {
        try {
            $sql = "SELECT t.*, st.status_name, c.category_name, u.email as client_email 
                     FROM ticket t 
                     INNER JOIN ticket_status st ON t.status_id = st.status_id 
                     INNER JOIN category c ON t.category_id = c.category_id 
                     INNER JOIN user u ON t.client_user_id = u.user_id 
                     WHERE t.status_id = $status_id
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
        
            $slaModel = new SLAModel();
            
            $sql = "INSERT INTO ticket (title, description, priority, status_id, category_id, client_user_id) 
                     VALUES ('$object->title', '$object->description', '$object->priority', 
                             $object->status_id, $object->category_id, $object->client_user_id)";
            
            $ticketId = $this->connection->executeSQL_DML_last($sql);
            
            // Create record in status history
            $statusHistoryModel = new StatusHistoryModel();
            $historyData = [
                'ticket_id' => $ticketId,
                'previous_status_id' => null,
                'new_status_id' => $object->status_id,
                'changed_by_user_id' => $object->client_user_id
            ];
            $statusHistoryModel->create($historyData);
            
            return $this->get($ticketId);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function update($object)
    {
        try {
            $sql = "UPDATE ticket SET 
                     title = '$object->title', 
                     description = '$object->description', 
                     priority = '$object->priority', 
                     status_id = $object->status_id, 
                     category_id = $object->category_id 
                     WHERE ticket_id = $object->ticket_id";
            
            $result = $this->connection->executeSQL_DML($sql);
            return $this->get($object->ticket_id);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function updateStatus($ticket_id, $status_id)
    {
        try {
            // First get current status
            $currentTicket = $this->get($ticket_id);
            
            $sql = "UPDATE ticket SET status_id = $status_id WHERE ticket_id = $ticket_id";
            $result = $this->connection->executeSQL_DML($sql);
            
            // Record in history
            $statusHistoryModel = new StatusHistoryModel();
            $historyData = [
                'ticket_id' => $ticket_id,
                'previous_status_id' => $currentTicket->status_id,
                'new_status_id' => $status_id,
                'changed_by_user_id' => 1 
            ];
            $statusHistoryModel->create($historyData);
            
            return $this->get($ticket_id);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getTicketStatistics()
    {
        try {
            $sql = "SELECT 
                        st.status_name,
                        COUNT(t.ticket_id) as ticket_count
                     FROM ticket_status st
                     LEFT JOIN ticket t ON st.status_id = t.status_id
                     GROUP BY st.status_id, st.status_name
                     ORDER BY ticket_count DESC";

            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}