<?php

try {
    $host = $_ENV['DB_HOST'];
    $service = $_ENV['DB_SERVICE'];
    $server = $_ENV['DB_SERVER'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];
    $database = $_ENV['DB_NAME'];

    $db =  new PDO("informix:host=$host; service=$service;database=$database; server=$server; protocol=onsoctcp;EnableScrollableCursors=1", "$user", "$pass");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    
} catch (PDOException $e) {
    echo json_encode([
        "detalle" => $e->getMessage(),       
        "mensaje" => "ERROR DE CONDEXION A LA BASE DE DATOS",

        "codigo" => 5,
    ]);
    header('Location: /');
    exit;
}
