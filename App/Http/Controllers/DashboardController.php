<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Core\Http\Controller;
use Core\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $lists = new ShoppingList();

        return View::make('dashboard/index', [
            'lists' => $lists->all()
        ]);
    }

}