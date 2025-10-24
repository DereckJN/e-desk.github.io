<?php
class CategoryTagModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT ct.*, c.category_name, t.tag_name 
                     FROM category_tag ct 
                     INNER JOIN category c ON ct.category_id = c.category_id 
                     INNER JOIN tag t ON ct.tag_id = t.tag_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByCategory($category_id)
    {
        try {
            $sql = "SELECT ct.*, t.tag_name, t.status as tag_status
                     FROM category_tag ct 
                     INNER JOIN tag t ON ct.tag_id = t.tag_id 
                     WHERE ct.category_id = $category_id
                     AND t.status = 'Active'";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByTag($tag_id)
    {
        try {
            $sql = "SELECT ct.*, c.category_name, c.status as category_status
                     FROM category_tag ct 
                     INNER JOIN category c ON ct.category_id = c.category_id 
                     WHERE ct.tag_id = $tag_id
                     AND c.status = 'Active'";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function addTagToCategory($category_id, $tag_id)
    {
        try {
            $sql = "INSERT INTO category_tag (category_id, tag_id) 
                     VALUES ($category_id, $tag_id)";
            
            $result = $this->connection->executeSQL_DML($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create($object)
    {
        try {
            $sql = "INSERT INTO category_tag (category_id, tag_id) 
                     VALUES ($object->category_id, $object->tag_id)";
            
            $result = $this->connection->executeSQL_DML($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}