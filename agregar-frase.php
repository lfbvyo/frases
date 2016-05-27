<?php
header('Content-Type: application/javascript');
require_once 'DataBase.php';
$db       = new DataBase();
$values   = "'".$_GET['nombre']."', '".$_GET['frase']."'";
$columns   = "nombre, frase";
$frases   = $db->insert(
    $values, $columns,  "frases"
);
printResults(array(true));
