<?php

namespace Model;

class Productos extends ActiveRecord {

    public static $tabla = 'productos';
    public static $columnasDB = [
        'nombre_producto',
        'cantidad_producto',
        'id_categoria',
        'id_prioridad',
        'estado',
        'situacion_producto'
    ];

    public static $idTabla = 'id_producto';
    public $id_producto;
    public $nombre_producto;
    public $cantidad_producto;
    public $id_categoria;
    public $id_prioridad;
    public $estado;
    public $situacion_producto;

    public function __construct($args = []){
        $this->id_producto = $args['id_producto'] ?? null;
        $this->nombre_producto = $args['nombre_producto'] ?? '';
        $this->cantidad_producto = $args['cantidad_producto'] ?? '';
        $this->id_categoria = $args['id_categoria'] ?? 0;
        $this->id_prioridad = $args['id_prioridad'] ?? 0;
        $this->estado = $args['estado'] ?? 0;
        $this->situacion_producto = $args['situacion_producto'] ?? 1;
    }

}