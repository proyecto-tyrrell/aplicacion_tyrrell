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

if (isset($_POST['filtrar'])){
    if(!empty($_POST['fecha-hora'])){
        $fecha_hora = $_POST['fecha-hora'];
    }
    $filtro = "DATE(fecha_inicio) = '".$fecha_hora."'";
}else{
    $filtro = "DATE(fecha_inicio) = '".date("Y-m-d")."'";
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
<form method="post">
    <div>
        <label for="fecha-hora">Fecha y hora:</label>
        <input type="date" id="fecha-hora" name="fecha-hora" required>
    </div>
    <div>
        <button type="submit" class="btn" name="filtrar">Filtrar</button>
    </div>
</form>
<?php
    if ($_SESSION['rol'] == 'adm'){
?>
        <div>
            <a href="agregarEvento.php" class="btn">Crear nuevo evento</a>
        </div>
<?php
    }
    if (mysqli_num_rows($result) > 0){
?>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)){ ?>
            <li>
                <p><?php echo "Inicio: ".$row['fecha_inicio'].", fin: ".$row['fecha_fin'].", lugar: ".$row['lugar'] ?></p>
            </li>
        <?php
        } 
        ?>
    </ul>
<?php
    }else{
?>
    <p>Sin eventos cargados</p>
<?php
    }
?>
<script src="desplegable.js"></script>
</body>
</html>