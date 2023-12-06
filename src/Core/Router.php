<?php
namespace TodoList\Project\Core;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use TodoList\Project\Config\ViewConfig;

class Router
{
    /**
     * All routes
     */
    public $routes = [];
    function __construct()
    {
        $controllers = glob(ROOT . "/src/Controllers/*.php");
        foreach ($controllers as $key => $controllerPath) {
            $controller = str_replace(".php", "", basename($controllerPath));
            $toBe = "\\TodoList\\Project\\Controllers\\" . $controller;
            $reflect = new ReflectionClass($toBe);
            $methods = $reflect->getMethods(ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $reflectionMethod) {
                $routeAttributes = $reflectionMethod->getAttributes(Route::class);

                foreach ($routeAttributes as $routeAttribute) {
                    $route = $routeAttribute->newInstance();
                    $this->routes[] = [
                        'controller' => $controller,
                        'action' => $reflectionMethod->name,
                        'path' => $route->getPath(),
                        'method' => $route->getMethod()
                    ];
                }
            }
        }
    }

    /**
     * Return `true` if route has been finded.
     * Otherwise `return` false.
     */
    public function init(): bool
    {
        $hasFind = false;
        foreach ($this->routes as $key => $route) {
            // Check if path and method match with a route
            if ($route["path"] === $this->getRequestUri() && $route["method"] === $_SERVER["REQUEST_METHOD"]) {
                $controllerPath = '\\TodoList\\Project\\Controllers\\' . $route["controller"];
                $controller = new $controllerPath;
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
        $notFoundView = ViewConfig::getNotFoundView();
        // If config had notfound view and view is not found
        if (isset($notFoundView) && !$hasFind) {
            // Start new ViewManager
            $viewManager = new ViewManager();
            // Render notfound view
            $viewManager->render($notFoundView);
        }

        return $hasFind;
    }

    /**
     * Get request uri without query string
     */
    private function getRequestUri()
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
    private function runController(mixed $controller, string $action)
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