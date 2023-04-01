<?php

declare(strict_types=1);

namespace Core;

use Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view,
        protected array  $params = []
    )
    {

    }

    public static function make(string $view, array $params = []): static
    {
        self::echoView($view, $params);

        return new static($view, $params);
    }

    private static function echoView($view, $params): void
    {
        echo new static($view, $params);
    }

    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        foreach ($this->params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        $this->checkAuth(VIEW_PATH . '/layouts/' . 'header' . '.php');
        include $viewPath;
        $this->checkAuth(VIEW_PATH . '/layouts/' . 'footer' . '.php');

        return (string)ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }

    private function checkAuth(string $view): void
    {
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true && !array_key_exists('error', $this->params)) {
            if ($this->view !== 'auth/login' && !str_contains($this->view, 'payments')) {
                include $view;
            } else if (str_contains($this->view, 'payments')) {
                $_SESSION['payment'] = true;
            } else {
                Redirect::route('/home');
            }
        }
    }
}