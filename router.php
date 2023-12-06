<?php
use TodoList\Project\Core\Router;

// Instanciate router
$router = new Router();

try {
    // Check if route has controller
    $router->init();
} catch (Exception $e) {
    // Handle all errors
    echo $e->getMessage() . "</br>";
    echo $e->getTraceAsString();
}
?>