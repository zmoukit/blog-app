<?php

namespace Controllers;

use Core\Request;

class HomeController extends BaseController
{
    public function home()
    {
        return $this->render("home");
    }
}
