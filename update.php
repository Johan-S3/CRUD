<?php

require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

$nombre = $_REQUEST["nombre"];
$apellido = $_REQUEST["apellido"];
$correo = $_REQUEST["correo"];
$fecha = $_REQUEST["fecha"];
$genero = $_REQUEST["genero"];
$ciudad = $_REQUEST["ciudad"];
$lenguaje = $_REQUEST["lenguaje"];
$id_usuario = $_REQUEST["id_usuario"];

$reGex_correo = "/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/ ";

if (empty($nombre) || empty($apellido) || !preg_match($reGex_correo, $correo)) {
?>
    <h1>Error en algun campo</h1>
<?php
    if(!preg_match($reGex_correo, $correo)){
    ?>
        <p>El correo enviado es invalido...</p>
    <?php
    }else{
    ?>
        <p>El nombre o apellido no pueden estar vacios...</p>
    <?php
    }
}
else{
    $sqlUpdate = "UPDATE usuarios set nombres=:nombres, apellidos=:apellidos, correo=:correo, fecha_nacimiento=:fecha, id_genero=:genero, id_ciudad=:ciudad where id_usuario = :id_usuario";
    $stm = $conexion->prepare($sqlUpdate);
    $stm->bindParam(':nombres', $nombre);
    $stm->bindParam(':apellidos', $apellido);
    $stm->bindParam(':correo', $correo);
    $stm->bindParam(':fecha', $fecha);
    $stm->bindParam(':genero', $genero);
    $stm->bindParam(':ciudad', $ciudad);
    $stm->bindParam(':id_usuario', $id_usuario);
    $stm->execute();
    
    $sqlDelete = "DELETE from lenguaje_usuarios where  id_usuario = :id_usuario";
    $stmD = $conexion->prepare($sqlDelete);
    $stmD->bindParam(':id_usuario', $id_usuario);
    $stmD->execute();
    
    $sqlLenguajes = "INSERT INTO lenguaje_usuarios(id_usuario, id_lenguaje) values (:id_usuario, :id_lenguaje)";
    $stmL = $conexion->prepare($sqlLenguajes);
    foreach($lenguaje as $key => $value){
        $stmL->bindParam(':id_usuario', $id_usuario);
        $stmL->bindParam(':id_lenguaje', $value);
        $stmL->execute();
    }
    
    header("Location: vista.php");
}

