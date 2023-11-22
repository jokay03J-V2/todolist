<?php
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