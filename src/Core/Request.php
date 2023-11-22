<?php
final class Request
{
    /**
     * Request method
     * It can be: POST, GET
     */
    public string $method = "GET";
    /**
     * Request uri
     */
    public string $uri;
    /**
     * Request params
     */
    public array $params = [];
    /**
     * Request query string
     */
    public array $query = [];
    /**
     * Request files
     */
    public array $files = [];
    /**
     * Request body
     * Note: request body only work on POST method
     */
    public array $body = [];
    /**
     * Request client ip
     */
    public string $ip = "";

    function __construct()
    {
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->uri = $_SERVER["REQUEST_URI"];
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->files = $_FILES;
        $this->body = $_POST;
        $this->query = $_GET;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
?>