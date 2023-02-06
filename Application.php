<?php

namespace Spike\core;

use Spike\core\db\Database;
use Spike\core\services\RouteServices;

class Application
{
    public string $layout = 'main';
    public string $userClass;

    public static string $ROOT_DIR;
    public static Application $app;

    public RouteServices $service;
    public Response $response;
    public Request $request;
    public Route $route;
    public Database $db;
    public Session $session;
    public ?UserModel $user;
    public View $view;

    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->db = new Database($config['db']);
        $this->request = new Request();
        $this->response = new Response();
        $this->service = new RouteServices();
        $this->route = new Route($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();

        $primaryValue = $this->session->get('user');

        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([
                $primaryKey => $primaryValue
            ]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        $this->service->boot();
        try {
            echo $this->route->resolve();
        }catch(\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}