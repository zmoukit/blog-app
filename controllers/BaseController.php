<?php

namespace Controllers;

use Core\Application;

class BaseController
{
    protected string $layout = "app";

    public function render($view, $params = [])
    {
        return Application::$app->getRouter()->renderView($view, $params);
    }

    /**
     * Get controller layout
     * 
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set controller layout
     * 
     * @param string $layout
     * 
     * @return $this BaseController
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }
}
