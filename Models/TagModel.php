<?php
class TagModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = new MySqlConnect();
    }

    public function all()
    {
        try {
            $sql = "SELECT t.*, COUNT(ct.category_id) as category_count
                     FROM tag t
                     LEFT JOIN category_tag ct ON t.tag_id = ct.tag_id
                     GROUP BY t.tag_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($id)
    {
        try {
            $sql = "SELECT t.*, COUNT(ct.category_id) as category_count
                     FROM tag t
                     LEFT JOIN category_tag ct ON t.tag_id = ct.tag_id
                     WHERE t.tag_id = $id
                     GROUP BY t.tag_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result[0];
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByCategory($category_id)
    {
        try {
            $sql = "SELECT t.*
                     FROM tag t
                     INNER JOIN category_tag ct ON t.tag_id = ct.tag_id
                     WHERE ct.category_id = $category_id
                     AND t.status = 'Active'";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getActiveTags()
    {
        try {
            $sql = "SELECT t.*, COUNT(ct.category_id) as category_count
                     FROM tag t
                     LEFT JOIN category_tag ct ON t.tag_id = ct.tag_id
                     WHERE t.status = 'Active'
                     GROUP BY t.tag_id";
            
            $result = $this->connection->ExecuteSQL($sql);
            return $result;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}