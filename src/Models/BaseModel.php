<?php
namespace TodoList\Project\Models;

use PDO;
use TodoList\Project\Core\Database;

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