<head>
    <link rel="stylesheet" href="CSS/tabla.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
</head>
<?php
require("conexion.php");

$db = new Conexion;
$conexion = $db->getConexion();

$sqlLisarUsers = "SELECT u.id_usuario, u.nombres, u.apellidos, u.correo, u.fecha_nacimiento, g.genero, c.ciudad from usuarios u inner join generos g on u.id_genero = g.id_genero
inner join ciudades c on u.id_ciudad = c.id_ciudad";
$stm3 = $conexion->prepare($sqlLisarUsers);
$stm3 ->execute();
$usuarios = $stm3->fetchAll();
if (empty($usuarios)) {
?>
    <h1>NO HAY USUARIOS REGISTRADOS</h1>
<?php
}else{
    ?>
    <table class="table">
        <thead class="table__head">
            <tr>
                <th>ID usuario</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Fecha nacimiento</th>
                <th>Genero</th>
                <th>Ciudad</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody class="table__body">
        <?php
        foreach ($usuarios as $key => $value) {
        ?>
            <tr>
                <td><?= $value["id_usuario"]?></td>
                <td><?= $value["nombres"]?></td>
                <td><?= $value["apellidos"]?></td>
                <td><?= $value["correo"]?></td>
                <td><?= $value["fecha_nacimiento"]?></td>
                <td><?= $value["genero"]?></td>
                <td><?= $value["ciudad"]?></td>
                <td><a href="editar.php?id=<?= $value["id_usuario"]?>"><i class="ri-edit-2-fill table__button"></i></a></td>
                <td><a href="delete.php?id=<?= $value["id_usuario"]?>"><i class="ri-delete-bin-5-fill table__button"></i></td>
            </tr>
        <?php
        }?>
        </tbody>
    </table>
<?php    
}
?>
<a class="button" href="index.php">Agregar</a>

