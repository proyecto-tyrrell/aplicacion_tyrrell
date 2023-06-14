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
$id = $_GET['id'];
$sql = "SELECT u.id, u.dni, u.nombreApellido FROM usuarios u JOIN eventoUsuarios eu on u.id = eu.usuario_id WHERE eu.evento_id = '".$id."'";

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
        <li><a href="index.php">Cerrar sesion</a></li>
    </ul>
</nav>
<div>
    <h3>Confirmar ingreso</h3>
    <form method="post">
        <ul>
            <?php
                $ingresoSql = $sql." and eu.ingreso is null";
                $result = mysqli_query($conn, $ingresoSql);
                while ($row = mysqli_fetch_assoc($result)){ ?>
                <li>
                    <div>
                        <label for="<?php echo $row['dni']; ?>"><?php echo $row['nombreApellido']; ?></label>
                        <input type="checkbox" id="<?php echo $row['dni']; ?>" name="usuariosIngreso[]" value="<?php echo $row['id']; ?>">
                    </div>
                </li>
            <?php
                }
                echo date_default_timezone_get();
            ?>
        </ul>
        <div>
            <button type="submit" class="btn" name="confirmar-ingreso">Confirmar</button>
        </div>
    </form>
</div>
<div>
    <h3>Confirmar salida</h3>
    <form method="post">
        <ul>
            <?php 
                $salidaSql = $sql." and eu.ingreso is not null and eu.salida is null";
                $result = mysqli_query($conn, $salidaSql);
                while ($row = mysqli_fetch_assoc($result)){ ?>
                <li>
                    <div>
                        <label for="<?php echo $row['dni']; ?>"><?php echo $row['nombreApellido']; ?></label>
                        <input type="checkbox" id="<?php echo $row['dni']; ?>" name="usuariosSalida[]" value="<?php echo $row['id'] ; ?>">
                    </div>
                </li>
            <?php
                } 
            ?>
        </ul>
        <div>
            <button type="submit" class="btn" name="confirmar-salida">Confirmar</button>
        </div>
    </form>
</div>
<?php
    if (!empty($_GET['mensaje'])){
?>
    <div>
        <p>Se han confirmado los cambios</p>
    </div>
<?php
    }

if (isset($_POST['confirmar-ingreso'])){
    $usuariosSeleccionados = isset($_POST['usuariosIngreso']) ? $_POST['usuariosIngreso'] : [];

    // Cargar usuarios ingresados
    foreach ($usuariosSeleccionados as $usuario_id) {
        $sqlCargarIngreso = "UPDATE eventoUsuarios set ingreso = '".date('Y-m-d H:i:s')."' WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $sqlCargarIngreso);
        echo $sqlCargarIngreso;
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
    exit();
}

if (isset($_POST['confirmar-salida'])){
    $usuariosSeleccionados = isset($_POST['usuariosSalida']) ? $_POST['usuariosSalida'] : [];

    // Cargar usuarios ingresados
    foreach ($usuariosSeleccionados as $usuario_id) {
        $sqlCargarSalida = "UPDATE eventoUsuarios set salida = '".date('Y-m-d H:i:s')."' WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $sqlCargarSalida);
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
    exit();
}
?>
<script src="desplegable.js"></script>
</body>
</html>