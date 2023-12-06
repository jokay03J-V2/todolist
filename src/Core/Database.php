<?php
namespace TodoList\Project\Core;

use PDO;

class Database
{
    /**
     * Connected database instance
     */
    protected $instance;

    function __construct()
    {
        $dbname = CONFIG["database"]["name"];
        $dbhost = CONFIG["database"]["host"];
        $dbport = CONFIG["database"]["port"];
        $dbuser = CONFIG["database"]["user"];
        $dbpass = CONFIG["database"]["password"];
        $this->instance = new PDO("mysql:dbname=$dbname;host=$dbhost;port=$dbport", $dbuser, $dbpass);
    }

    /**
     * Get connected database instance
     */
    function db()
    {
        return $this->instance;
    }
}
?>