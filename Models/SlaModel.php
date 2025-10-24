<?php
class SLAModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT s.*, COUNT(c.category_id) as category_count
                     FROM sla s
                     LEFT JOIN category c ON s.sla_id = c.sla_id
                     GROUP BY s.sla_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($id)
    {
        try {
            $sql = "SELECT s.*, COUNT(c.category_id) as category_count
                     FROM sla s
                     LEFT JOIN category c ON s.sla_id = c.sla_id
                     WHERE s.sla_id = $id
                     GROUP BY s.sla_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result[0];
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByCategory($category_id)
    {
        try {
            $sql = "SELECT s.*
                     FROM sla s
                     INNER JOIN category c ON s.sla_id = c.sla_id
                     WHERE c.category_id = $category_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result[0];
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getActiveSLAs()
    {
        try {
            $sql = "SELECT s.*, COUNT(c.category_id) as category_count
                     FROM sla s
                     LEFT JOIN category c ON s.sla_id = c.sla_id
                     WHERE s.status = 'Active'
                     GROUP BY s.sla_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}