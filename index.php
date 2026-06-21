<?php
require_once __DIR__ . '/app/init.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\EscuelaController;

$router = new Router();

$router->get('/', function () {
    session_start();
    if (!empty($_SESSION['escuela_id'])) {
        header('Location: ' . base_url('/dashboard'));
    } else {
        header('Location: ' . base_url('/login'));
    }
    exit;
});

$router->get('/login', [AuthController::class, 'loginView']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/registro', [AuthController::class, 'registroView']);
$router->post('/registro', [AuthController::class, 'registro']);

$router->get('/dashboard', [DashboardController::class, 'index']);

$router->get('/escuela', [EscuelaController::class, 'index']);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);
