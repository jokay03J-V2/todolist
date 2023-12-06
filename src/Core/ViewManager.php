<?php
namespace TodoList\Project\Core;

use Exception;

class ViewManager
{
    /**
     * 
     */
    public $viewPath = "/src/Views/";

    /**
     * Render a view
     */
    public function render(string $view, array $data = array())
    {
        // Check if php and html view exist
        if (file_exists(ROOT . $this->viewPath . $view . ".php") || file_exists(ROOT . $this->viewPath . $view . ".html")) {
            extract($data);
            // Create a manager for handle ressources
            $ressources = new RessourceManager();
            // Turn on output buffering
            ob_start();
            // Execute view
            include(ROOT . $this->viewPath . $view . ".php");
            $content = ob_get_clean();
            // Render view
            include(ROOT . $this->viewPath . "layout.php");
        } else {
            throw new Exception("View doesn't found");
        }

    }
}
?>