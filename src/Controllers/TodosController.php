<?php
class TodosController extends BaseController
{
    /**
     * Show todos
     */
    function index(Request $request, Response $response)
    {
        // Check if user is connected, otherwise redirect to login page
        if (!isset($_SESSION["user"])) {
            $response->locateTo("/login");
            return $response;
        }

        $todoModel = new TodoModel();
        // Get all todo
        $todos = $todoModel->getAll($_SESSION["user"]["id"]);
        // Render all todo
        $this->view->render("home", ["todos" => $todos]);
    }

    /**
     * Update todo logic
     */
    function update(Request $request, Response $response)
    {
        // Check if user is connected, otherwise redirect to login page
        if (!isset($_SESSION["user"])) {
            $response->locateTo("/login");
            return $response;
        }

        // Check if body include content and id
        if (isset($request->body["content"]) && isset($request->body["id"])) {
            $todoModel = new TodoModel();
            // Update todo
            $hasBeenUpdated = $todoModel->updateById($request->body["id"], $_SESSION["user"]["id"], $request->body["content"], date("Y-m-d H:i:s"));
            // Check if todo has been updated
            if ($hasBeenUpdated) {
                // Send "No content" http code
                $response->setStatus(204);
                return $response;
            } else {
                // Send error message with forbidden http code
                $response->setStatus(403);
                $response->json(["error" => ["message" => "Forbidden"]]);
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
        // Check if user is connected, otherwise redirect to login page
        if (!isset($_SESSION["user"])) {
            $response->locateTo("/login");
            return $response;
        }
        $todoModel = new TodoModel();
        // Check if content has been provided
        if (!empty($request->body["content"])) {
            // Create new todo
            $todoModel->create($_SESSION["user"]["id"], htmlspecialchars($request->body["content"]));
        }
        // Fetch all todos and render it
        $todos = $todoModel->getAll($_SESSION["user"]["id"]);
        $this->view->render("home", ["todos" => $todos]);
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