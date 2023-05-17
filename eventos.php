<?php

require"ConexionDB.php";

//obtener los valores de inicio de sesion
session_start();

//verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    //si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}

//conectarse a la base de datos
$conn = connect();

if (isset($_GET['filtrar'])){
    if(!empty($_GET['fecha-hora'])){
        $fecha_hora = $_GET['fecha-hora'];
    }
    $filtro = "Date(fecha_inicio) = ".$fecha_hora;
}else{
    $filtro = "DATE(fecha_inicio) = ".date("Y-m-d");
}

$sql = "SELECT * from eventos WHERE ".$filtro." ORDER BY fecha_inicio";

$result = mysqli_query($conn, $sql);

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
<form method="post">
    <div>
        <label for="fecha-hora">Fecha y hora:</label>
        <input type="datetime-local" id="fecha-hora" name="fecha-hora" required>
    </div>
    <div>
        <button type="submit" class="btn" name="filtrar">Filtrar</button>
    </div>
</form>
<div>
    <a href="agregarEvento.php" class="btn">Crear nuevo evento</a>
</div>
<ul>
    <!-- aca imprimir eventos -->
</ul>
<script src="desplegable.js"></script>
</body>
</html>