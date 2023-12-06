<?php
namespace TodoList\Project\Models;

use Exception;
use PDO;

class TodoModel extends BaseModel
{
    public $table = "todo";

    /**
     * Get all todos by a author.
     */
    function getAll(int $authorId)
    {
        // Prepare query
        $sql = "SELECT TODO_ID, TODO_CONTENT, TODO_CREATED_AT FROM " . $this->table . " WHERE USER_ID = :authorId ORDER BY TODO_CREATED_AT DESC";
        $preparedQuery = $this->db->prepare($sql);
        $validSql = $preparedQuery->execute(["authorId" => $authorId]);
        // Check if query has been correctly executed
        if ($validSql) {
            // Fetch all rows and return it
            $todos = $preparedQuery->fetchAll(PDO::FETCH_ASSOC);
            return $todos;
        } else {
            throw new Exception("An error was occured");
        }
    }

    /**
     * Create a todo.
     */
    function create(int $authorId, string $todoContent, string $createdAt)
    {
        // Prepare query
        $sql = "INSERT INTO " . $this->table . "(USER_ID, TODO_CONTENT, TODO_CREATED_AT) VALUES (:authorId, :todoContent, :createdAt)";
        $preparedQuery = $this->db->prepare($sql);
        $validSql = $preparedQuery->execute(["authorId" => $authorId, "todoContent" => $todoContent, "createdAt" => $createdAt]);
        // Check if query has been correctly executed
        if ($validSql) {
            // Return created todo id 
            return $this->db->lastInsertId();
        } else {
            throw new Exception("An error was occured");
        }
    }

    /**
     * Delete todo by it's id and author.
     * Return true if todo was deleted otherwise it return false.
     */
    function deleteById(int $id, int $authorId)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE TODO_ID = :todoId AND USER_ID = :authorId";
        $preparedQuery = $this->db->prepare($sql);
        $validSql = $preparedQuery->execute(["todoId" => $id, "authorId" => $authorId]);
        if ($validSql) {
            return $preparedQuery->rowCount() ? true : false;
        } else {
            throw new Exception("An error was occured");
        }
    }

    function updateById(int $id, int $authorId, string $update, string $updatedDate)
    {
        $sql = "UPDATE " . $this->table . " SET TODO_CONTENT = :content, TODO_CREATED_AT = :createdAt WHERE TODO_ID = :todoId AND USER_ID = :authorId";
        $preparedQuery = $this->db->prepare($sql);
        $validSql = $preparedQuery->execute(["todoId" => $id, "authorId" => $authorId, "content" => $update, "createdAt" => $updatedDate]);
        if ($validSql) {
            return $preparedQuery->rowCount() ? true : false;
        } else {
            throw new Exception("An error was occured");
        }
    }
}
?>