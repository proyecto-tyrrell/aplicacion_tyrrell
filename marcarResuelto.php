<?php

require("ConexionDB.php");

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

// Verificar si se recibió el ID del mensaje y el ID del vehículo
if (isset($_GET['observacionId']) && isset($_GET['resuelto'])){
    // Obtener los valores recibidos por POST
    $observacionId = $_GET['observacionId'];
    $resuelto = $_GET['resuelto'];

    if ($resuelto == 1){
        $sql = "UPDATE mensajeVehiculos SET resuelto = 1 WHERE id = $observacionId";
    }else{
        $sql = "UPDATE mensajeVehiculos SET resuelto = 0 WHERE id = $observacionId";
    }

    mysqli_query($conn, $sql);

    header("Location: vehiculos.php");

    exit;
} else {
    header("Location: vehiculos.php");

    exit;
}
