<?php 
require_once __DIR__ . '/../includes/app.php';


use Controllers\ProductosController;
use MVC\Router;
use Controllers\AppController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/productos', [ProductosController::class, 'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductosController::class, 'guardarAPI']);


$router->comprobarRutas();