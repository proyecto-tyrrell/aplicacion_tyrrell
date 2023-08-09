<?php
    require("/home/u602072991/public_html/public_html/aplicacion/ConexionDB.php");
    
    // Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
    $conn = connect();

    $sqlBusqueda = "SELECT eU.id as id, e.fecha_fin as fin from eventoUsuarios eU JOIN eventos e ON e.id = eU.evento_id WHERE eU.ingreso IS NOT NULL AND eU.salida IS NULL and e.id IN (SELECT id FROM eventos WHERE fecha_fin < CURDATE());";

    $result = mysqli_query($conn, $sqlBusqueda);

    while ($row = mysqli_fetch_assoc($result)) {
        $sqlUpdate = "UPDATE eventoUsuarios SET  salida = '". $row['fin'] ."' WHERE id = '". $row['id'] ."'";
        mysqli_query($conn, $sqlUpdate);
        echo "Una salida actualizada con exito";
    }
?>