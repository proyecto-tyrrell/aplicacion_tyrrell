<?php
//obtener los valores de inicio de sesion
session_start();

//verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    //si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}

require 'ValidarCredenciales.php';
// Obtener el nombre de usuario del parámetro de la URL
$nombre_usuario = $_GET['nombreApe'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - adm</title>
    <link rel="stylesheet" href="estilos\admStyle.css">
</head>
<body>
<header>
    <a href="index.php"><img src="imagenes\tyrrell.jpeg" alt="logo" id="logo"></a>
</header>
<nav id="sidebar">
    <button id="desplegar"></button>
    <ul>
        <li><a href="adm-asistencia.php">Asistencia</a></li>
        <li><a href="#">Recibo de sueldo</a></li>
    </ul>
</nav>
<?php
    // Incluir la sección HTML en la que deseas mostrar el nombre de usuario
    echo "<div id='bienvenida'>
            <p>Bienvenido, $nombre_usuario</p>
        </div>";
?>
<script src="adm-scripts.js"></script>
</body>
</html>