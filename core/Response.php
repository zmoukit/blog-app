<?php

namespace Core;

class Response
{

    /**
     * Set the HTTP response code
     * 
     * @var int $code
     * 
     * @return int|bool
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * Redirect to a specific url
     * 
     * @param string $url
     * 
     * @return void
     */
    public function redirect(string $url): void
    {
        header('Location: ' . $url);
    }
}
