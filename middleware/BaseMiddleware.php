<?php

namespace Spike\core\middleware;

abstract class BaseMiddleware
{
    abstract public function execute();
}