<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Core\Http\Controller;
use Core\Redirect;
use Core\View;

class HomeController extends Controller
{
    public function index(): Redirect|View
    {
        return View::make('auth/login');
    }

    public function notFound(): View
    {
        return View::make('errors/404', ['error' => 404]);
    }
}