<?php

namespace Core;

class Redirect
{
    public static function url(string $url, $code): static
    {
        header("Location: " . $url, true, $code);
        exit();
    }

    public static function route(string $url = '', array $messages = [], $code = 301): static
    {
        if ($messages) {
            foreach ($messages as $key => $value) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION[$key] = $value;
            }
        }

        if ($url === '/error' && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        }

        return self::url($url, $code);
    }
}