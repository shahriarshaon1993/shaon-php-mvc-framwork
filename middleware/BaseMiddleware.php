<?php

namespace boompearl\phpmvc\middleware;

abstract class BaseMiddleware
{
    abstract public function execute();
}