<?php
// Set server default time zone
date_default_timezone_set("Europe/Paris");
// Start session
session_start();
// Loads config
if (file_exists("./config.json")) {
    $routes = json_decode(file_get_contents("./config.json"), true);
    $configResult = array();
    foreach ($routes as $key => $value) {
        $configResult[$key] = $value;
    }
    define("CONFIG", $configResult);
    $root = str_replace("\\", "/", __DIR__);
    define("ROOT", $root);
} else {
    throw new Exception("You must have a config");
}

// Autoload
spl_autoload_register(function ($class) {
    foreach (CONFIG["autoload"] as $key => $value) {
        if (file_exists(ROOT . "/" . $value . "/" . $class . ".php")) {
            include_once ROOT . "/" . $value . "/" . $class . ".php";
            break;
        }
    }
});

// Load router
include("./router.php");
?>