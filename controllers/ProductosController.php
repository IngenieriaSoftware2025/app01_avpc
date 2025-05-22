<?php

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;

class ProductosController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
     
        $sql_categorias = "SELECT * FROM categorias WHERE categoria_situacion = 1 ORDER BY categoria_nombre";
        $categorias = self::fetchArray($sql_categorias);
        
        $sql_prioridades = "SELECT * FROM prioridades WHERE prioridad_situacion = 1 ORDER BY prioridad_orden";
        $prioridades = self::fetchArray($sql_prioridades);
        
        $router->render('productos/index', [
            'categorias' => $categorias,
            'prioridades' => $prioridades
        ]);
    }
}