<?php

require("conexion.php");

$db = new Conexion;
$conexion = $db->getConexion();


$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo = $_POST["correo"];
$fecha_nacimiento = $_POST["fecha"];
$genero = $_POST["genero"];
$ciudad = $_POST["ciudad"];
$lengauje = $_POST["lenguaje"];


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
    $sql = "INSERT INTO usuarios (nombres, apellidos, correo, fecha_nacimiento, id_genero, id_ciudad) VALUES ( :nombre, :apellido, :correo, :fecha, :genero, :ciudad)";
    
    $stm = $conexion->prepare($sql);
    $stm->bindParam(':nombre', $nombre);
    $stm->bindParam(':apellido', $apellido);
    $stm->bindParam(':correo', $correo);
    $stm->bindParam(':fecha', $fecha_nacimiento);
    $stm->bindParam(':genero', $genero);
    $stm->bindParam(':ciudad', $ciudad);
    
    $stm->execute();
    
    $id_usuario = $conexion->lastInsertId();
    
    
    $sqlLenguajeUser = "INSERT INTO lenguaje_usuarios (id_usuario, id_lenguaje) VALUES ( :usuario, :lenguaje)";
    $stm2 = $conexion->prepare($sqlLenguajeUser);
    foreach ($lengauje as $key => $value) {
        $stm2->bindParam(':usuario', $id_usuario);
        $stm2->bindParam(':lenguaje', $value);
        $stm2->execute();
    }
    
    
    header("Location: vista.php");
}



