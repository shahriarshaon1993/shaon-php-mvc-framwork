<?php

namespace Spike\core\services;

use Spike\core\Application;

class RouteServices 
{
    public function boot()
    {
        require_once Application::$ROOT_DIR.'/route/web.php';
    }
}