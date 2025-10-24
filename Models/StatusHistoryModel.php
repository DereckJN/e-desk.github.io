<?php
class StatusHistoryModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT sh.*, 
                     ps.status_name as previous_status,
                     ns.status_name as new_status,
                     u.email as user_changed,
                     t.title as ticket_title
                     FROM status_history sh
                     LEFT JOIN ticket_status ps ON sh.previous_status_id = ps.status_id
                     INNER JOIN ticket_status ns ON sh.new_status_id = ns.status_id
                     INNER JOIN user u ON sh.changed_by_user_id = u.user_id
                     INNER JOIN ticket t ON sh.ticket_id = t.ticket_id
                     ORDER BY sh.change_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($id)
    {
        try {
            $sql = "SELECT sh.*, 
                     ps.status_name as previous_status,
                     ns.status_name as new_status,
                     u.email as user_changed,
                     t.title as ticket_title
                     FROM status_history sh
                     LEFT JOIN ticket_status ps ON sh.previous_status_id = ps.status_id
                     INNER JOIN ticket_status ns ON sh.new_status_id = ns.status_id
                     INNER JOIN user u ON sh.changed_by_user_id = u.user_id
                     INNER JOIN ticket t ON sh.ticket_id = t.ticket_id
                     WHERE sh.history_id = $id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result[0];
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTicket($ticket_id)
    {
        try {
            $sql = "SELECT sh.*, 
                     ps.status_name as previous_status,
                     ns.status_name as new_status,
                     u.email as user_changed
                     FROM status_history sh
                     LEFT JOIN ticket_status ps ON sh.previous_status_id = ps.status_id
                     INNER JOIN ticket_status ns ON sh.new_status_id = ns.status_id
                     INNER JOIN user u ON sh.changed_by_user_id = u.user_id
                     WHERE sh.ticket_id = $ticket_id
                     ORDER BY sh.change_date DESC";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create($object)
    {
        try {
            $sql = "INSERT INTO status_history (ticket_id, previous_status_id, new_status_id, changed_by_user_id, observations) 
                     VALUES ($object->ticket_id, " . 
                     ($object->previous_status_id ? "$object->previous_status_id" : "NULL") . ", 
                     $object->new_status_id, $object->changed_by_user_id, 
                     " . (isset($object->observations) ? "'$object->observations'" : "NULL") . ")";
            
            $result = $this->connection->executeSQL_DML_last($sql);
            return $this->get($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}