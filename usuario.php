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
    <a href="usuario.php" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
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
    <button class="btn" type="submit">Ver Recibo de haberes</button>
    <button class="btn" type="submit">Novedades</button>
    <button class="btn" type="submit">Solicitudes</button>
	<button class="btn" type="submit">Eventos</button> 
    <button class="btn" type="submit">Vehiculos</button>
    <button class="btn" type="submit">Empleados</button>
</div>

<script src="desplegable.js"></script>
</body>
</html>