<?php

namespace Model;

class Categorias extends ActiveRecord {

    public static $tabla = 'categorias';
    public static $columnasDB = [
        'categoria_nombre',
        'categoria_codigo',
        'categoria_situacion'
    ];

    public static $idTabla = 'categoria_id';
    public $categoria_id;
    public $categoria_nombre;
    public $categoria_codigo;
    public $categoria_situacion;

    public function __construct($args = []){
        $this->categoria_id = $args['categoria_id'] ?? null;
        $this->categoria_nombre = $args['categoria_nombre'] ?? '';
        $this->categoria_codigo = $args['categoria_codigo'] ?? '';
        $this->categoria_situacion = $args['categoria_situacion'] ?? 1;
    }
}



