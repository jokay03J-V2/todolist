<?php
namespace TodoList\Project\Core;

use Attribute;

#[Attribute]
class Route
{
    private string $path;
    private string $method;
    private array|null $params;

    public function __construct(string $path, string $method = "GET", array|null $params = [])
    {
        $this->path = $path;
        $this->method = $method;
        $this->params = $params;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
?>