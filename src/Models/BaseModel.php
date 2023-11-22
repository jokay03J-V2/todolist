<?php
class BaseModel
{
    /**
     * Table name should be used to perform query
     */
    public $table = "unknow";
    /**
     * Intance of connected database
     */
    public PDO $db;

    public function __construct()
    {
        $db = new Database();
        $this->db = $db->db();
    }
}
?>