<?php

namespace Model;

class Prioridades extends ActiveRecord {

    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'prioridad_nombre',
        'prioridad_orden',
        'prioridad_situacion'
    ];

    public static $idTabla = 'prioridad_id';
    public $prioridad_id;
    public $prioridad_nombre;
    public $prioridad_orden;
    public $prioridad_situacion;

    public function __construct($args = []){
        $this->prioridad_id = $args['prioridad_id'] ?? null;
        $this->prioridad_nombre = $args['prioridad_nombre'] ?? '';
        $this->prioridad_orden = $args['prioridad_orden'] ?? 1;
        $this->prioridad_situacion = $args['prioridad_situacion'] ?? 1;
    }

}