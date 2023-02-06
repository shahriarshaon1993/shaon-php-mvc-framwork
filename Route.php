<?php

namespace boompearl\phpmvc;

use boompearl\phpmvc\exception\NotFoundException;

class Route
{
    public Request $request;
    public Response $response;

    protected static $routes = [];
        
    /**
     * 
     * @param  Object $request
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    /**
     * assign path & in routes array.
     *
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public static function get($path, $callback)
    {
        self::$routes['get'][$path] = $callback;
    }
    
    /**
     * post
     *
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public static function post($path, $callback)
    {
        self::$routes['post'][$path] = $callback;
    }
        
    /**
     * Route go to right way
     *
     * @return void
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = self::$routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }
        
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            /** @var \app\core\controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}