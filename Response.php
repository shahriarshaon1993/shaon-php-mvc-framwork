<?php

namespace boompearl\phpmvc;

class Response
{    
    /**
     * setStatusCode
     *
     * @param  int $code
     * @return integer
     */
    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: '.$url);
    }
}