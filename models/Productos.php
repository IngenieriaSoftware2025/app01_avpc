<?php

namespace Model;

class Producto extends ActiveRecord {
 
    public static $tabla = 'productos';
    public static $columnasDB = [
        'producto_id',
        'producto_nombre',
        'producto_cantidad',
        'categoria_id',
        'prioridad_id',
        'producto_comprado',
        'producto_situacion'
    ];

    public static $idTabla = 'producto_id';
    
 
    public $producto_id;
    public $producto_nombre;
    public $producto_cantidad;
    public $categoria_id;
    public $prioridad_id;
    public $producto_comprado;
    public $producto_situacion;

    public $categoria_nombre;
    public $prioridad_nombre;


    public function __construct($args = []) {
        $this->producto_id = $args['producto_id'] ?? null;
        $this->producto_nombre = $args['producto_nombre'] ?? '';
        $this->producto_cantidad = $args['producto_cantidad'] ?? '';
        $this->categoria_id = $args['categoria_id'] ?? '';
        $this->prioridad_id = $args['prioridad_id'] ?? '';
        $this->producto_comprado = $args['producto_comprado'] ?? 0;
        $this->producto_situacion = $args['producto_situacion'] ?? 1;
        
        $this->categoria_nombre = $args['categoria_nombre'] ?? '';
        $this->prioridad_nombre = $args['prioridad_nombre'] ?? '';
    }
}