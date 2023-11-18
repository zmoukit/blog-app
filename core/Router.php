<?php

namespace Core;

class Router
{
    /**
     * @var \Core\Request $request
     */
    private Request $request;

    /**
     * @var \Core\Response $response
     */
    private Response $response;

    /**
     * Router construct
     * 
     * @param \Core\Request $request
     * @param \Core\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    /**
     * @var array $routes
     */
    protected array $routes;

    /**
     * create a new get route
     * 
     * @param string $path
     * @param function | callback $callback
     * 
     * @return void
     */
    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * create a new post route
     * 
     * @param string $path
     * @param function | callback $callback
     * 
     * @return void
     */
    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * match request route with a route from our routes list
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            return  $this->renderView("errors/404");
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            Application::$app->setController($callback[0]);
        }

        return  call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->getLayoutContent();
        $viewContent = $this->getViewContent($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function getLayoutContent()
    {
        $layout = 'app';
        if (Application::$app->getController()) {
            $layout = Application::$app->getController()->getLayout() ?? 'app';
        }
        ob_start();
        include_once Application::$ROOT_PATH . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function getViewContent($view, $params)
    {
        ob_start();
        include_once Application::$ROOT_PATH . "/views/$view.php";
        return ob_get_clean();
    }
}
