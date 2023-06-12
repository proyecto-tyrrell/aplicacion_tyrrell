<?php
//obtener los valores de inicio de sesion
session_start();

//verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    //si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - adm</title>
    <link rel="stylesheet" href="estilos\Style.css">
</head>
<body>
<header>
    <a href="principal.php" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>
<nav id="sidebar">
    <button id="desplegar"></button>
    <ul>
        <li><a href="index.php">Cerrar sesion</a></li>
    </ul>
</nav>
<div id='bienvenida'>
    <p>Bienvenido, <?php echo $nombre_usuario?></p>
</div>
<div class="container-botones">
    <a href="" class="btn">Ver Recibo de haberes</a>
    <a href="" class="btn">Novedades</a>
    <a href="solicitud.php" class="btn">Solicitudes</a>
    <a href="eventos.php" class="btn">Eventos</a>
    <a href="vehiculos.php" class="btn">Vehiculos</a>
    <a href="empleados.php" class="btn">Empleados</a>
    <a href="proyectos.php" class="btn">Proyectos</a>
    <a href="" class="btn">RRHH</a>
</div>

<script src="desplegable.js"></script>
</body>
</html>