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
    <title>Tyrrell - usuario</title>
    <link rel="stylesheet" href="estilos\usuarioStyle.css">
</head>
<body>
<header>
    <a href="<?php if($_SESSION['rol'] == "adm"){echo "adm.php";}else{if($_SESSION['rol'] == "usr"){echo "usuario.php";}};?>" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>
<nav id="sidebar">
    <button id="desplegar"></button>
    <ul>
        <li><a href="adm-asistencia.php">Asistencia</a></li>
        <li><a href="#">Recibo de sueldo</a></li>
    </ul>
</nav>
<div id='bienvenida'>
    <p>Bienvenido, <?php echo $nombre_usuario ?></p>
</div>
<div class="container-botones">
    <a href="" class="btn">Ver Recibo de haberes</a>
    <a href="" class="btn">Novedades</a>
    <a href="" class="btn">Solicitudes</a>
    <a href="eventos.php" class="btn">Eventos</a>
    <a href="vehiculos.php" class="btn">Vehiculos</a>
    <a href="empleados.php" class="btn">Empleados</a>
</div>

<script src="desplegable.js"></script>
</body>
</html>