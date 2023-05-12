<?php

    //obtener los valores de inicio de sesion
session_start();

//verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    //si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];


    // Verificar si se recibieron los datos del formulario
    if(isset($_POST['lista']) && isset($_POST['problema'])) {
        // Obtener los valores del formulario
        $elemento = $_POST['lista'];
        $problema = $_POST['problema'];

        // Dirección de correo a la que se enviará el mensaje
        $destinatario = "administracion@tyrrell.com.ar";

        // Asunto del correo
        $asunto = "Problemas con vehiculo";

        // Construir el mensaje
        $mensaje = "Elemento seleccionado: " . $elemento . "\n";
        $mensaje .= "Descripción del problema: " . $problema;

        // Cabeceras del correo/ tengo que poner los mails a los usuarios
        $cabeceras = "De: " . $nombre_usuario;

        // Enviar el correo electrónico
        if(mail($destinatario, $asunto, $mensaje, $cabeceras)) {
            echo "Correo enviado correctamente.";
        } else {
            echo "Error al enviar el correo.";
        }
    } else {
        echo "Error: no se recibieron los datos del formulario.";
    }
?>
