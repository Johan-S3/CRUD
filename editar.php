<head>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<?php

require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

$sqlCiudades = "SELECT * FROM ciudades";
$banderaCiudades = $conexion->prepare($sqlCiudades);
$banderaCiudades->execute();
$ciudades = $banderaCiudades->fetchAll();

// echo "<pre>";
// print_r($ciudades);
// echo "</pre>";

$sqlGeneros = "SELECT * FROM generos";
$banderaGeneros = $conexion->prepare($sqlGeneros);
$banderaGeneros->execute();
$generos = $banderaGeneros->fetchAll();

// echo "<pre>";
// print_r($_GET["id"]);
// echo "</pre>";

$sqlLenguajes = "SELECT * FROM lenguajes";
$banderaLenguajes = $conexion->prepare($sqlLenguajes);
$banderaLenguajes->execute();
$lenguajes = $banderaLenguajes->fetchAll();

// echo "<pre>";
// print_r($lenguajes);
// echo "</pre>";

$usuario_id = $_REQUEST["id"];
$sqlUsuarios = "SELECT* FROM usuarios where id_usuario = $usuario_id";
$prepareUsuarios = $conexion->prepare($sqlUsuarios);
$prepareUsuarios->execute();
$usuario = $prepareUsuarios->fetch();

// echo "<pre>";
// print_r($usuario);
// echo "</pre>";

$sqlLenguajeUsuario = "SELECT* FROM lenguaje_usuarios where id_usuario = $usuario_id";
$prepareLenguaje = $conexion->prepare($sqlLenguajeUsuario);
$prepareLenguaje->execute();
$lenguajeUsuario = $prepareLenguaje->fetchAll();


?>

<form action="update.php" method="get" class="form">
    <h1 class="form__tittle">EDITAR</h1>
    <div> 
        <label for="nombre" class="form__label">Nombres: </label>
        <input class="form__input" type="text" id="nombre" name="nombre" placeholder="Ingrese nombre" pattern="^[a-zA-Z{2,}]$" require autocomplete="off" value="<?=$usuario["nombres"]?>">
    </div>
    <br>
    <div>
        <label for="apellido" class="form__label">Apellido: </label>
        <input class="form__input" type="text" id="apellido" name="apellido" placeholder="Ingrese apellido" pattern="^[a-zA-Z{2,}]$" required autocomplete="off" value="<?=$usuario["apellidos"]?>">
    </div>
    <br>
    <div>
        <label for="correo" class="form__label">Correo: </label>
        <input class="form__input" type="text" id="correo" name="correo" placeholder="Ingrese correo" required autocomplete="off" value="<?=$usuario["correo"]?>">
    </div>
    <br>
    <div>
        <label for="fecha" class="form__label">Fecha de nacimiento: </label>
        <input class="form__input" type="date" id="fecha" name="fecha" placeholder="Ingrese fecha" max="<?=date("Y")?>-<?=date("m")?>-<?=date("d")?>" required autocomplete="off" value="<?=$usuario["fecha_nacimiento"]?>">
    </div>
    <br>
    <div>
        <label class="form__label--GENERO">Genero: </label><br>
        <?php
        foreach ($generos as $key => $value){
        ?>
        <input class="form__input--GENERO" type="radio" name="genero" value="<?= $value['id_genero']?>" id="genero_<?= $value['id_genero']?>" require
        <?php
        if($value['id_genero'] == $usuario["id_genero"]){
            ?> checked <?php
        }
        ?>>
        <label for="genero_<?=$value['id_genero']?>"> <?=$value['genero']?> </label>
        <br>
        <?php
        }
        ?>
    </div>
    <br>
    <div>
        <label for="id_ciudad" class="form__label">Ciudad:  </label>
        <select class="form__select" name="ciudad" id="id_ciudad">
            <?php foreach ($ciudades as $key => $value)
            {?>
                <option class="form__option" id="<?=$value['id_ciudad']?>" value="<?=$value['id_ciudad']?>"
                <?php
                if($value['id_ciudad'] == $usuario["id_ciudad"]){
                    ?> selected <?php
                }
                ?>>
                    <?=$value['ciudad']?>
                </option>
                <?php
            }?>
        </select>
    </div>
    <br>
    <div>
        <label class="form__label">Lenguajes: </label><br>
        <?php
        foreach ($lenguajes as $key => $value){
        ?>
        <input type="checkbox" name="lenguaje[]" id="len_<?=$value['id_lenguaje']?>" value=<?=$value['id_lenguaje']?>
        <?php
        foreach($lenguajeUsuario as $key => $valor){
            if($valor['id_lenguaje'] == $value['id_lenguaje']){
                ?> checked <?php
            }
        }
        ?>>
        <label for="len_<?=$value['id_lenguaje']?>"> <?= $value["lenguaje"]?> </label>
        <br>
        <?php
        }
        ?>
    </div>
    <br>
    <input type="hidden" name="id_usuario" value=<?=$usuario_id?>>
    <button class="form__button">Guardar datos</button>
</form>
<a href="vista.php" class="button">Ver usuarios</a>