<?php

namespace Model;

class Productos extends ActiveRecord {

    public static $tabla = 'productos';
    public static $columnasDB = [
        'producto_nombre',
        'producto_cantidad',
        'producto_categoria_id',
        'producto_prioridad_id',
        'producto_comprado',
        'producto_situacion'
    ];

    public static $idTabla = 'producto_id';
    public $producto_id;
    public $producto_nombre;
    public $producto_cantidad;
    public $producto_categoria_id;
    public $producto_prioridad_id;
    public $producto_comprado;
    public $producto_situacion;

    public function __construct($args = []){
        $this->producto_id = $args['producto_id'] ?? null;
        $this->producto_nombre = $args['producto_nombre'] ?? '';
        $this->producto_cantidad = $args['producto_cantidad'] ?? 1;
        $this->producto_categoria_id = $args['producto_categoria_id'] ?? null;
        $this->producto_prioridad_id = $args['producto_prioridad_id'] ?? null;
        $this->producto_comprado = $args['producto_comprado'] ?? 0;
        $this->producto_situacion = $args['producto_situacion'] ?? 1;
    }

   
}