<?php

require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

$id_usuario = $_REQUEST["id"];

$sqlL = "DELETE FROM lenguaje_usuarios where id_usuario = :id_usuario";
$stmL = $conexion->prepare($sqlL);
$stmL->bindParam(':id_usuario', $id_usuario);
$stmL->execute();

$sql = "DELETE from usuarios where id_usuario = :id_usuario";
$stm = $conexion->prepare($sql);
$stm->bindParam(':id_usuario', $id_usuario);
$stm->execute();

header("Location: vista.php");
