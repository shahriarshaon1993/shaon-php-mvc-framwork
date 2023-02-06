<?php

namespace boompearl\phpmvc\services;

use boompearl\phpmvc\Application;

class RouteServices 
{
    public function boot()
    {
        require_once Application::$ROOT_DIR.'/route/web.php';
    }
}