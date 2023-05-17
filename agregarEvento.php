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

$sqlProyectos = "SELECT * FROM proyectos ORDER BY codigo";
$proyectos = mysqli_query($conn, $sqlProyectos);

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
        <label for="proyecto">Proyecto:</label>
        <select name="proyecto" id="proyecto">
            <option value="" selected disabled>Seleccione un proyecto</option>
            <?php
                while ($P = mysqli_fetch_asocc($proyectos)){
            ?>
                <option value="<?php echo $P['id']; ?>"><?php echo $P['codigo']; ?></option>
            <?php
            }
            ?>
        </select>
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