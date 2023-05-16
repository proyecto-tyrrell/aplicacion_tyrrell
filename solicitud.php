<?php
include"ConexionDB.php";

// Obtener los valores de inicio de sesión
session_start();

// Verificar si el token de inicio de sesión está presente en la variable $_SESSION
if (empty($_SESSION['token'])) {
    // Si no está el token de inicio de sesión, redirigir al index
    header('Location: index.php');
    exit;
}

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];
//QUERY
$sql = "SELECT nombre from proyectos order by nombre ASC ;";

$result = mysqli_query($conn , $sql);

// ------------------------------------------------------------------------------------


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - solicitudes</title>
    <link rel="stylesheet" href="estilos\admStyle.css">
</head>
<body>
<header>
    <a href="<?php if($_SESSION['rol'] == "adm"){echo "adm.php";}else{if($_SESSION['rol'] == "usr"){echo "usuario.php";}};?>" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>






<!-- FORMULARIO -->
<form action="enviar_correo.php" method="post">
    <label for="lista"><?php echo $nombre_usuario ?> Seleccione un proyecto si es lo que tiene:</label>
    <select name="lista" id="lista">
        <?php 
        while ($fila = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $fila['nombre'] . "'>" . $fila['nombre'] . "</option>";
        }
        
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </select>
    <br><br>
    
    <label for="solicitud">Solicito la cantidad de dinero para:</label>
    <textarea name="mensaje" id="mensaje" rows="4" cols="50" required></textarea>
    <br><br>
    
    <div>
        <button type="submit">Enviar</button>
    </div>
</form>


<?php 

function enviarCorreo(){
    // Verificar si se recibieron los datos del formulario
    if (!empty($_POST['lista']) && !empty($_POST['solicitud'])) {
        // Obtener los valores del formulario
        $elemento = $_POST['lista'];
        $problema = $_POST['solicitud'];

        // Dirección de correo a la que se enviará el mensaje
        $destinatario = "administracion@tyrrell.com.ar";

        // Asunto del correo
        $asunto = "Solicitud de dinero";

        // Construir el mensaje
        $mensaje = "Elemento seleccionado: " . $elemento . "\n";
        $mensaje .= "Descripcion del problema: " . $problema;

        // Cabeceras del correo (correo del remitente)
        $cabeceras = "From: " . $nombre_usuario;

        // Enviar el correo electrónico
        if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
            echo "Correo enviado correctamente.";
        } else {
            echo "Error al enviar el correo.";
        }
    } else {
        echo "Error: no se recibieron los datos del formulario.";
    }

}
?>


<!--  FIN FORMULARIO -->

</body>
</html>