<?php

namespace Core\Middleware;

use Core\Redirect;

class AuthMiddleware
{
    public function run()
    {
        try {
            if (!array_key_exists('logged', $_SESSION) && $_SESSION['logged'] !== true) {
                session_destroy();
                return Redirect::route('/');
            }
        } catch (\Exception $e) {
            return Redirect::route('/error', (array)$e->getMessage());
        }
    }
}