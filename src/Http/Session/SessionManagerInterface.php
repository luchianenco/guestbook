<?php

namespace App\Http\Session;

/**
 * Interface SessionManagerInterface
 * @package App\Http\Session
 */
interface SessionManagerInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value);

    /**
     * @param string $key
     * @return SessionManagerInterface
     */
    public function destroy(string $key): SessionManagerInterface;
}
