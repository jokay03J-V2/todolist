<?php
class TodosController extends BaseController
{
    /**
     * Show todos
     */
    function index(Request $request, Response $response)
    {
        $userConnected = isset($_SESSION["user"]);
        // Check if user is connected, otherwise redirect to login page
        if (!$userConnected) {
            $response->locateTo("/login");
            return $response;
        }

        $todoModel = new TodoModel();
        // Get all todo
        $todos = $todoModel->getAll($_SESSION["user"]["id"]);
        // Render all todo
        $this->view->render("home", ["todos" => $todos, "userConnected" => $userConnected]);
    }

    /**
     * Update todo logic
     * Note: This route is only used for AJAX request
     */
    function update(Request $request, Response $response)
    {
        // Check if user is connected, otherwise send 401 code
        if (!isset($_SESSION["user"])) {
            $response->json(["error" => ["message" => "You must be connected"]]);
            $response->setStatus(401);
            return $response;
        }

        // Check if body include content and id
        if (isset($request->body["content"]) && strlen($request->body["content"]) <= 255 && isset($request->body["id"])) {
            $todoModel = new TodoModel();
            $date = date("Y-m-d H:i:s");
            // Update todo
            $hasBeenUpdated = $todoModel->updateById($request->body["id"], $_SESSION["user"]["id"], $request->body["content"], $date);
            // Check if todo has been updated
            if ($hasBeenUpdated) {
                // Send updated content
                $response->json(["updatedAt" => date("d-m-Y H:i:s", strtotime($date)), "content" => htmlspecialchars($request->body["content"])]);
                return $response;
            } else {
                // Send error message with 404 code
                $response->setStatus(404);
                $response->json(["error" => ["message" => "Todo not founded"]]);
                return $response;
            }
        } else {
            // Handle all required body error
            $response->json(["error" => ["message" => "id and content is required !"]]);
            $response->setStatus(400);
            return $response;
        }
    }

    /**
     * Create todo logic
     */
    function create(Request $request, Response $response)
    {
        $isConnected = isset($_SESSION["user"]);
        // Check if user is connected, otherwise redirect to login page
        if (!$isConnected) {
            $response->locateTo("/login");
            return $response;
        }
        $todoModel = new TodoModel();
        // Check if content has been provided and check if body is equal or lower than 255
        if (!empty($request->body["content"]) && strlen($request->body["content"]) <= 255) {
            // Add createdAt
            $createdAt = date("Y-m-d H:i:s");
            // Create new todo
            $todoModel->create($_SESSION["user"]["id"], htmlspecialchars($request->body["content"]), $createdAt);
        }
        // Fetch all todos and render it
        $todos = $todoModel->getAll($_SESSION["user"]["id"]);
        $this->view->render("home", ["todos" => $todos, "userConnected" => $isConnected]);
    }

    /**
     * Delete todo logic
     */
    function delete(Request $request, Response $response)
    {
        // Check if user is connected, otherwise redirect to login page
        if (isset($request->query["id"]) && isset($_SESSION["user"])) {
            $todoModel = new TodoModel();
            $hasBeenDeleted = $todoModel->deleteById($request->query["id"], $_SESSION["user"]["id"]);
            // Inform user if the todo has been deleted or not
            if ($hasBeenDeleted) {
                return $this->view->render("todos/delete", ["notifications" => [["type" => "success", "message" => "La todo à bien été supprimé."]]]);
            } else {
                return $this->view->render("todos/delete", ["notifications" => [["type" => "danger", "message" => "Vous n'avez pas les droits pour supprimé cette todo."]]]);
            }
        } else {
            $response->locateTo("/");
            return $response;
        }
    }
}
?>