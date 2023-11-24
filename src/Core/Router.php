<?php
class Router
{
    /**
     * All routes
     */
    public $routes = array();
    function __construct()
    {
        // Check if routes file exist
        if (file_exists(ROOT . "/src/Config/routes.json")) {
            // Transform JSON to an array
            $routes = json_decode(file_get_contents(ROOT . "/src/Config/routes.json"), true);
            foreach ($routes["routes"] as $key => $value) {
                array_push($this->routes, $routes["routes"][$key]);
            }
        } else {
            throw new Exception("You must have a routes file !");
        }
    }

    /**
     * Return `true` if route has been finded.
     * Otherwise `return` false.
     */
    public function findRoute(): bool
    {
        $hasFind = false;
        foreach ($this->routes as $key => $route) {
            // Check if path and method match with a route
            if ($route["path"] === $this->getRequestUri() && $route["method"] === $_SERVER["REQUEST_METHOD"]) {
                $controller = new $route["controller"];
                $action = $route["action"];
                // Check if controller has method
                if (method_exists($controller, $action)) {
                    // Run controller
                    $this->runController($controller, $action);
                    $hasFind = true;
                    break;
                } else {
                    throw new Exception("Method doesn't exist on controller");
                }
            }
        }

        // If config had notfound view and view is not found
        if (isset(CONFIG["views"]["notfound"]) && !$hasFind) {
            // Start new ViewManager
            $viewManager = new ViewManager();
            // Render notfound view
            $viewManager->render(CONFIG["views"]["notfound"]);
        }

        return $hasFind;
    }

    /**
     * Get request uri without query string
     */
    public function getRequestUri()
    {
        $uri = $_SERVER["REQUEST_URI"];
        // Get latest ? position
        $pos = strrpos($uri, "?");
        // Check if request uri has query string
        if ($pos !== false) {
            $result = "";
            // Start to index 0 until ? index position - 1
            for ($i = 0; $i < $pos; $i++) {
                $result = $result . $uri[$i];
            }
            return $result;
        } else {
            return $uri;
        }
    }

    /**
     * Run controller method and display response
     */
    public function runController(mixed $controller, string $action)
    {
        // Create base response and request
        $baseResponse = new Response();
        $baseRequest = new Request();
        // Run controller and pass request and response
        $controllerResult = call_user_func(array($controller, $action), $baseRequest, $baseResponse);
        // Check if response is type Response for create custom response
        // eg: if you want only return json for REST api
        if ($controllerResult instanceof Response) {
            // update response content type and get response data for send it
            $result = $controllerResult->sendResponse();
            echo $result;
        } else if (isset($controllerResult)) {
            // send raw data without able to change his content-type
            echo $controllerResult;
        }
    }
}
?>