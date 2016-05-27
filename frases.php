<?php
header('Content-Type: application/javascript');
require_once 'DataBase.php';
$db       = new DataBase();
$frases   = $db->select(
    "nombre, frase", 
    "frases"
);
printResults($frases);

