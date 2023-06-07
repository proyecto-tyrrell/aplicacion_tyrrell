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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - usuario</title>
    <link rel="stylesheet" href="estilos\Style.css">
</head>
<body>
<header>
    <a href="principal.php" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>
<nav id="sidebar">
    <button id="desplegar"></button>
    <ul>
        <li><a href="">Asistencia</a></li>
        <li><a href="#">Recibo de sueldo</a></li>
    </ul>
</nav>
<form method="post">
    <div>
        <label for="nombre">Nombre del proyecto:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
    </div>
    <div>
        <label for="codigo">Codigo del proyecto:</label>
        <input type="text" id="codigo" name="codigo" placeholder="Codigo" required>
    </div>
    <div>
        <button type="submit" class="btn" name="agregar">Agregar proyecto</button>
    </div>
</form>
<?php
    if (isset($_POST['agregar'])){
        if(!empty($_POST['nombre']) and !empty($_POST['codigo'])){
            $nombre = $_POST['nombre'];
            $codigo = $_POST['codigo'];
            //consulta a la base de datos
            $sql = "INSERT INTO proyectos (nombre, codigo) VALUES ('".$nombre."', '".$codigo."')";
            try{
                mysqli_query($conn, $sql)
            ?>
                <p>Se ha agregado correctamente</p>
            <?php
            }catch(EXCEPTION $e){
            ?>
                <p>Ha ocurrido un error, por favor intentelo mas tarde</p>
            <?php
            }
        }
    }
?>
<script src="desplegable.js"></script>
</body>
</html>