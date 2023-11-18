<?php

namespace Core;

class Session
{
    protected const SESSION_FLASH_MESSAGES_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::SESSION_FLASH_MESSAGES_KEY] ?? [];

        $messages = array_map(function ($flashMessage) {
            $flashMessage['remove'] = true;
            return $flashMessage;
        }, $flashMessages);

        $_SESSION[self::SESSION_FLASH_MESSAGES_KEY] = $messages;
    }

    /**
     * Push a flash message into the global session array
     * 
     * @param string $key
     * @param string $message
     * 
     * @return void
     */
    public function setFlash(string $key, string $message): void
    {
        $_SESSION[self::SESSION_FLASH_MESSAGES_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     * Get a flash message from the global session array
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function getFlash(string $key)
    {
        return $_SESSION[self::SESSION_FLASH_MESSAGES_KEY][$key]['value'] ?? false;
    }

    /**
     * 
     */
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::SESSION_FLASH_MESSAGES_KEY] ?? [];

        $messages = array_filter($flashMessages, function ($flashMessage) {
            return $flashMessage['remove'] === false;
        });

        $_SESSION[self::SESSION_FLASH_MESSAGES_KEY] = $messages;
    }

    /**
     * Store item in session
     * 
     * @param string $key
     * @param mixte $key
     * 
     * @return void
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get item from session
     * 
     * @param string $key
     * 
     * @return mixte
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Remove item from session
     * 
     * @param string $key
     * 
     * @return void
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
