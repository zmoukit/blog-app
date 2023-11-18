<?php

namespace Core;

class Request
{
    /**
     * Return HTTP request path
     * 
     * @return string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strrpos($path, '?');
        if ($position === false)
            return $path;

        return substr($path, 0, $position);
    }

    /**
     * Return HTTP request method
     * 
     * @return string
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Check if it's get request
     * 
     * @return boolean
     */
    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Check if it's post request
     * 
     * @return boolean
     */
    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Get request body
     * 
     * @return array
     */
    public function getBody()
    {
        $body = [];

        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
