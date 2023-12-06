<?php
namespace TodoList\Project\Controllers;

use Attribute;
use TodoList\Project\Core\ViewManager;

#[Attribute]
class BaseController
{
    /**
     * Instance of ViewManager
     */
    public ViewManager $view;

    function __construct()
    {
        $this->view = new ViewManager();
    }

}
?>