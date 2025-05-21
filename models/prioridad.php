<?php

namespace Model;

class Prioridad extends ActiveRecord {
   
    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'prioridad_id',
        'prioridad_nombre',
        'prioridad_codigo',
        'prioridad_situacion'
    ];

    public static $idTabla = 'prioridad_id';
    

    public $prioridad_id;
    public $prioridad_nombre;
    public $prioridad_codigo;
    public $prioridad_situacion;


    public function __construct($args = []) {
        $this->prioridad_id = $args['prioridad_id'] ?? null;
        $this->prioridad_nombre = $args['prioridad_nombre'] ?? '';
        $this->prioridad_codigo = $args['prioridad_codigo'] ?? '';
        $this->prioridad_situacion = $args['prioridad_situacion'] ?? 1;
    }
}