<?php

namespace App\Http\Session;

/**
 * Class SessionManager
 * @package App\Http\Session
 */
class SessionManager implements SessionManagerInterface
{
    /**
     * Start Session Manager
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     * @param $value
     * @return SessionManagerInterface
     */
    public function set(string $key, $value): SessionManagerInterface
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return SessionManagerInterface
     */
    public function destroy(string $key): SessionManagerInterface
    {
        session_destroy();

        return $this;
    }
}
