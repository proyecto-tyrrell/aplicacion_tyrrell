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
$sql = "SELECT * FROM usuarios u JOIN eventoUsuarios eu on u.id = eu.usuario_id WHERE eu.evento_id = '".$id."'";

$sqlSeleccionados = "SELECT * FROM asistencias WHERE evento_id = '".$id."' and usuario_id = ";

//conectarse a la base de datos
$conn = connect();

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
<div>
    <h3>Confirmar asistencia</h3>
    <form method="post">
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)){ ?>
                <li>
                    <div>
                        <label for="<?php echo $row['dni']; ?>"><?php echo $row['nombreApellido']; ?></label>
                        <input type="checkbox" id="<?php echo $row['dni']; ?>" name="usuarios[]" value="<?php echo $row['id']; ?>" 
                        <?php 
                            $sqlAux = $sqlSeleccionados.$row['id'];
                            $seleccionado = mysqli_fetch_assoc(mysqli_query($conn, $sqlAux));
                            if ( $seleccionado > 0){
                                echo "checked";
                            }
                        ?>
                        >
                    </div>
                </li>
            <?php
                } 
            ?>
        </ul>
        <div>
            <button type="submit" class="btn" name="confirmar-asistencia">Confirmar</button>
        </div>
    </form>
    <?php
    if (!empty($_GET['mensaje'])){
    ?>
        <p>Se han confirmado las asistencias</p>
    <?php
    }
    ?>
</div>
<?php
if (isset($_POST['confirmar-asistencia'])){
    $usuariosSeleccionados = isset($_POST['usuarios']) ? $_POST['usuarios'] : [];

    // Cargar usuarios presentes
    foreach ($usuariosSeleccionados as $usuario_id) {
        $sqlAsignarUsuario = "INSERT INTO asistencias (evento_id, usuario_id) VALUES ('".$id."', '$usuario_id')";
        $esta = "SELECT * FROM asistencias WHERE evento_id = '$id' AND usuario_id = '$usuario_id'";
        $cargado = mysqli_fetch_assoc(mysqli_query($conn, $esta));
        if ($cargado == 0){
            mysqli_query($conn, $sqlAsignarUsuario);
        }
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
    exit();
}
?>
<script src="desplegable.js"></script>
</body>
</html>