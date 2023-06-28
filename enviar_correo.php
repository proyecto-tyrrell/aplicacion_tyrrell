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

// Obtener la fecha actual
$fecha_actual = date("Y/m/d");

// Verificar si se recibieron los datos del formulario
if (!empty($_POST['lista']) && !empty($_POST['problema'])) {
    // Obtener los valores del formulario
    $elemento = $_POST['lista'];
    $problema = $_POST['problema'];

    // Dirección de correo a la que se enviará el mensaje
    $destinatario = "hnetto@tyrrell.com.ar>";

    // Asunto del correo
    $asunto = "Problemas con vehiculo";

    // Construir el mensaje
    $mensaje = "Elemento seleccionado: " . $elemento . "\n";
    $mensaje .= "Descripcion del problema: " . $problema;

    // Cabeceras del correo (correo del remitente)
    //$cabeceras = "From: " . $nombre_usuario;
    $cabeceras = "From: " ;
    // Enviar el correo electrónico
    if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
        echo "Correo enviado correctamente.";
    } else {
        echo "Error al enviar el correo.";
    }
} else {
    echo "Error: no se recibieron los datos del formulario.";
}

$getElemento_id = "SELECT id FROM vehiculos WHERE modelo = '".$elemento."'";
$elemento_id = mysqli_query($conn, $getElemento_id);
$id = mysqli_fetch_assoc($elemento_id);


// Insertar los datos en la tabla eventoVehiculos
$sql = "INSERT INTO mensajeVehiculos ( vehiculo_id,mensajeVehiculos, fecha) VALUES ('".$id['id']."', '$problema', '$fecha_actual')";
if (mysqli_query($conn, $sql)) {
    echo "Datos insertados correctamente en la tabla eventoVehiculos.";
} else {
    echo "Error al insertar los datos en la tabla eventoVehiculos: " . mysqli_error($conn);
}

?>
