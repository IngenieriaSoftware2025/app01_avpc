<?php
require_once __DIR__ . '/../includes/app.php';

//este documento recibe las peticiones y las redirige a los controladores correspondientes
//se requiere el autoload para cargar las clases
//require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\ProductoController;
use MVC\Router;
use Controllers\AppController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class, 'index']);

//ESTE ES EL URL PARA PRODUCTOS
$router->get('/productos', [ProductoController::class, 'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductoController::class, 'guardarAPI']);
$router->get('/productos/buscarAPI', [ProductoController::class, 'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductoController::class, 'modificarAPI']);
$router->get('/productos/eliminar', [ProductoController::class, 'EliminarAPI']);

$router->post('/productos/marcarCompradoAPI', [ProductoController::class, 'marcarCompradoAPI']);
$router->get('/productos/categoriasAPI', [ProductoController::class, 'categoriasAPI']);
$router->get('/productos/buscarCompradosAPI', [ProductoController::class, 'buscarCompradosAPI']);


$router->comprobarRutas();
//este es el archivo de rutas, se encarga de redirigir las peticiones a los controladores correspondientes