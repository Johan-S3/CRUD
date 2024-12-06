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
// print_r($generos);
// echo "</pre>";

$sqlLenguajes = "SELECT * FROM lenguajes";
$banderaLenguajes = $conexion->prepare($sqlLenguajes);
$banderaLenguajes->execute();
$lenguajes = $banderaLenguajes->fetchAll();

?>
<form action="controlador.php" method="post" class="form">
    <h1 class="form__tittle">REGISTRO</h1>
    <div> 
        <label for="nombre" class="form__label">Nombres: </label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingrese nombre" pattern="^[a-zA-Z{2,}]$" required autocomplete="off" class="form__input">
    </div>
    <br>
    <div>
        <label for="apellido" class="form__label">Apellidos: </label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingrese apellido" pattern="^[a-zA-Z{2,}]$" required autocomplete="off" class="form__input">
    </div>
    <br>
    <div>
        <label for="correo" class="form__label">Correo: </label>
        <input type="text" id="correo" name="correo" placeholder="Ingrese correo" required autocomplete="off" class="form__input">
    </div>
    <br>
    <div>
        <label for="fecha" class="form__label">Fecha de nacimiento: </label>
        <input type="date" id="fecha" name="fecha" placeholder="Ingrese fecha" max="<?=date("Y")?>-<?=date("m")?>-<?=date("d")?>" required autocomplete="off" class="form__input">
    </div>
    <br>
    <div>
        <label class="form__label">Genero: </label><br>
        <?php
        foreach ($generos as $key => $value){
        ?>
        <label class="form__label--genero" for="genero_<?=$value['id_genero']?>">
            <input class="form__input--genero" type="radio" name="genero" value="<?= $value['id_genero']?>" id="genero_<?= $value['id_genero']?>" required>
            <?=$value['genero']?>
        </label>
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
                <option class="form__option" id="<?=$value['id_ciudad']?>" value="<?=$value['id_ciudad']?>">
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
        <input type="checkbox" name="lenguaje[]" id="len_<?=$value['id_lenguaje']?>" value=<?=$value['id_lenguaje']?>>
        <label for="len_<?=$value['id_lenguaje']?>"> <?= $value["lenguaje"]?> </label>
        <br>
        <?php
        }
        ?>
    </div>
    <br>
    <button class="form__button">Guardar datos</button>
</form>

<a href="vista.php" class="button">Ver usuarios</a>