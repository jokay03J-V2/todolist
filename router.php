<?php
// Instanciate router
$router = new Router();

try {
    // Check if route has controller
    $router->findRoute();
} catch (Exception $e) {
    // Handle all errors
    echo $e->getMessage() . "</br>";
    echo $e->getTraceAsString();
}
?>