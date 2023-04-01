<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Core\Http\Router;

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

$route->post('/login', [AuthController::class, 'login']);
$route->post('/logout', [AuthController::class, 'logout'], 'auth');

$route->get('/404', [HomeController::class, 'notFound']);
$route->run();