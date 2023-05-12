<?php
    // Verificar si se recibieron los datos del formulario
    if(isset($_POST['lista']) && isset($_POST['problema'])) {
        // Obtener los valores del formulario
        $elemento = $_POST['lista'];
        $problema = $_POST['problema'];

        // Dirección de correo a la que se enviará el mensaje
        $destinatario = "administracion@tyrrell.com.ar";

        // Asunto del correo
        $asunto = "Mensaje del formulario de contacto";

        // Construir el mensaje
        $mensaje = "Elemento seleccionado: " . $elemento . "\n";
        $mensaje .= "Descripción del problema: " . $problema;

        // Cabeceras del correo/ tengo que poner los mails a los usuarios
        $cabeceras = "From: correo@dominio.com";

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
