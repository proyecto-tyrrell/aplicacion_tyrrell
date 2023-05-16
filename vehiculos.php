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

//QUERY
$sql = "SELECT modelo, patente from vehiculos order by modelo ASC ;";

$result = mysqli_query($conn , $sql);

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - vehiculos</title>
    <link rel="stylesheet" href="estilos\admStyle.css">
</head>
<body>
<header>
    <a href="<?php if($_SESSION['rol'] == "adm"){echo "adm.php";}else{if($_SESSION['rol'] == "usr"){echo "usuario.php";}};?>" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>


<!-- Seleccion de auto -->

<!-- Formulario para enviar problemas con los vehiculos -->
    <form action="enviar_correo.php" method="post">
            <label for="lista"><?php echo $nombre_usuario ?> Seleccione un vehiculo:</label>
            <select name="lista" id="lista">
                <?php 
                    // Generar las opciones de la lista desplegable
                    while ($fila = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $fila['modelo'] . "'>" . $fila['patente'] . "</option>";
                    }

                    // Liberar los resultados y cerrar la conexión
                    mysqli_free_result($result);
                    mysqli_close($conn);
                ?>
   
            </select>

            <br><br>

            <label for="problema">Describa su problema:</label>
            <textarea name="problema" id="problema" rows="4" cols="50"></textarea>

            <br><br>
            <div>
                <button type="submit">Enviar</button>
            </div>
            
    </form>



</body>
</html>