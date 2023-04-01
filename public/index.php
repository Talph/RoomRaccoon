<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use Core\Http\Router;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShoppingListController;
/**
 * Composer
 */
require '../vendor/autoload.php';

const VIEW_PATH = __DIR__ . '/../Views';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

$route = new Router();

$route->get('/', [HomeController::class, 'index']);
$route->get('/home', [DashboardController::class, 'index'], 'auth');

$route->get('/shopping-lists', [ShoppingListController::class, 'index'], 'auth');
$route->get('/shopping-lists/{id}', [ShoppingListController::class, 'show'], 'auth');
$route->get('/shopping-lists/create', [ShoppingListController::class, 'create'], 'auth');
$route->post('/shopping-lists/store', [ShoppingListController::class, 'store'], 'auth');
$route->post('/shopping-lists/update/{id}', [ShoppingListController::class, 'update'], 'auth');
$route->post('/shopping-lists/delete/{id}', [ShoppingListController::class, 'delete'], 'auth');
$route->post('/shopping-lists/destroy/{id}', [ShoppingListController::class, 'destroy'], 'auth');


$route->post('/login', [AuthController::class, 'login']);
$route->post('/logout', [AuthController::class, 'logout'], 'auth');

$route->get('/404', [HomeController::class, 'notFound']);
$route->run();