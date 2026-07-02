<?php
require_once __DIR__ . '/app/init.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\EscuelaController;
use App\Controllers\ParticipanteController;
use App\Controllers\JuezController;
use App\Controllers\TorneoController;
use App\Controllers\EvaluacionController;

$router = new Router();

$router->get('/', function () {
    session_start();
    if (!empty($_SESSION['escuela_id'])) {
        $dest = ($_SESSION['user_level'] ?? 1) == 2 ? '/evaluacion' : '/dashboard';
        header('Location: ' . base_url($dest));
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
$router->post('/escuela/editar', [EscuelaController::class, 'editar']);

$router->get('/participantes', [ParticipanteController::class, 'index']);
$router->get('/participantes/listar', [ParticipanteController::class, 'listar']);
$router->get('/participantes/obtener', [ParticipanteController::class, 'obtener']);
$router->post('/participantes/guardar', [ParticipanteController::class, 'guardar']);
$router->post('/participantes/actualizar', [ParticipanteController::class, 'actualizar']);
$router->post('/participantes/eliminar', [ParticipanteController::class, 'eliminar']);

$router->get('/jueces', [JuezController::class, 'index']);
$router->get('/jueces/listar', [JuezController::class, 'listar']);
$router->get('/jueces/obtener', [JuezController::class, 'obtener']);
$router->post('/jueces/guardar', [JuezController::class, 'guardar']);
$router->post('/jueces/actualizar', [JuezController::class, 'actualizar']);
$router->post('/jueces/eliminar', [JuezController::class, 'eliminar']);

$router->get('/torneos', [TorneoController::class, 'index']);
$router->get('/torneos/listar', [TorneoController::class, 'listar']);
$router->get('/torneos/obtener', [TorneoController::class, 'obtener']);
$router->post('/torneos/guardar', [TorneoController::class, 'guardar']);
$router->post('/torneos/actualizar', [TorneoController::class, 'actualizar']);
$router->post('/torneos/eliminar', [TorneoController::class, 'eliminar']);
$router->post('/torneos/unirse', [TorneoController::class, 'unirse']);
$router->get('/torneos/detalle', [TorneoController::class, 'detalle']);
$router->get('/torneos/participantes', [TorneoController::class, 'participantes']);
$router->post('/torneos/agregar-participante', [TorneoController::class, 'agregarParticipante']);
$router->post('/torneos/remover-participante', [TorneoController::class, 'removerParticipante']);
$router->post('/torneos/invitar-escuela', [TorneoController::class, 'invitarEscuela']);
$router->get('/torneos/listar-escuelas', [TorneoController::class, 'listarEscuelas']);
$router->get('/torneos/jueces', [TorneoController::class, 'jueces']);
$router->post('/torneos/agregar-juez', [TorneoController::class, 'agregarJuez']);
$router->post('/torneos/remover-juez', [TorneoController::class, 'removerJuez']);
$router->post('/torneos/salir', [TorneoController::class, 'salir']);
$router->post('/torneos/iniciar', [TorneoController::class, 'iniciar']);
$router->post('/torneos/finalizar', [TorneoController::class, 'finalizar']);
$router->post('/torneos/toggle-estado', [TorneoController::class, 'toggleEstado']);
$router->get('/torneos/categorias', [TorneoController::class, 'categorias']);
$router->post('/torneos/guardar-categoria', [TorneoController::class, 'guardarCategoria']);
$router->post('/torneos/actualizar-categoria', [TorneoController::class, 'actualizarCategoria']);
$router->post('/torneos/eliminar-categoria', [TorneoController::class, 'eliminarCategoria']);
$router->get('/torneos/puntajes', [TorneoController::class, 'puntajes']);

$router->get('/scoreboard', [TorneoController::class, 'scoreboard']);

$router->get('/evaluacion', [EvaluacionController::class, 'index']);
$router->get('/evaluacion/torneo', [EvaluacionController::class, 'torneo']);
$router->post('/evaluacion/guardar', [EvaluacionController::class, 'guardarPuntaje']);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);
