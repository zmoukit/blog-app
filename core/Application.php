<?php

namespace Core;

use Controllers\BaseController;

class Application
{
    private Router $router;
    private Request $request;
    private Response $response;
    private Session $session;
    public Database $db;
    public static $app;
    public ?BaseController $controller = null;

    public static string $ROOT_PATH;

    /**
     * Application constructor
     * 
     * @param string $rootPath
     * @param array $config
     */
    public function __construct(string $rootPath, array $config)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();

        self::$ROOT_PATH = $rootPath;
        self::$app = $this;

        $this->db = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * @return Core\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Get Application response
     * 
     * @return Core\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get application session array
     * 
     * @return Core\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return Controllers\BaseController
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param Controllers\BaseController $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }
}
