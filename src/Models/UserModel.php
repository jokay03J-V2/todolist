<?php
namespace TodoList\Project\Models;

use Exception;
use PDO;

class UserModel extends BaseModel
{
    public $table = "user";

    /**
     * Insert user into the database.
     */
    function create(string $username, string $password): int
    {
        // Prepare query
        $preparedQuery = $this->db->prepare("INSERT INTO " . $this->table . "(USER_NAME, USER_PASSWORD) VALUES (:username, :password)");
        $validSql = $preparedQuery->execute(["username" => $username, "password" => $password]);
        // Check if query has been correctly executed
        if ($validSql) {
            // Return created user id
            return $this->db->lastInsertId();
        } else {
            throw new Exception("An error was occured");
        }
    }

    /**
     * Get one user by it's username.
     * Throw an Exception when user is not found.
     */
    function getOneOrFail(string $username)
    {
        // Prepare query
        $query = "SELECT USER_ID, USER_NAME, USER_PASSWORD FROM " . $this->table . " WHERE USER_NAME = :username";
        $preparedQuery = $this->db->prepare($query);
        $validSql = $preparedQuery->execute(["username" => $username]);
        // Check if query has been correctly executed
        if ($validSql) {
            // Fetch one row
            $user = $preparedQuery->fetch(PDO::FETCH_ASSOC);
            // If fetched user is empty throw new error
            if (empty($user))
                throw new Exception("User not found");
            return $user;
        } else {
            throw new Exception("An error was occured");
        }
    }
}
?>