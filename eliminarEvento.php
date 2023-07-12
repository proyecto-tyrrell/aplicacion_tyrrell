<?php
    require "ConexionDB.php";
    
    // Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
    $conn = connect();

    $idEvento = $_POST['id-evento'];
    $eliminarVehiculos = "DELETE from eventoVehiculos WHERE evento_id = '".$idEvento."'";
    $eliminarUsuarios = "DELETE from eventoUsuarios WHERE evento_id = '".$idEvento."'";
    $eliminarEvento = "DELETE from eventos WHERE id = '".$idEvento."'";
    $actualizarNotificacion="DELETE from notificaciones WHERE evento_id = '".$idEvento."'";

    mysqli_query($conn, $eliminarVehiculos);
    mysqli_query($conn, $eliminarUsuarios);
    mysqli_query($conn, $eliminarEvento);
    mysqli_query($conn, $actualizarNotificacion);

    header("Location: eventos.php");
?>