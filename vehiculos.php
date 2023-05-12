<?php 

require"ConexionDB.php";

//obtener los valores de inicio de sesion
session_start();
//conectarse a la base de datos
$conn = connect();

//QUERY
$sql = "SELECT modelo, patente from vehiculos order by modelo ASC ;";

$result = mysqli_query($conn , $sql)

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
    <a href="adm.php" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>


<!-- Seleccion de auto -->
<div>
    
</div>

<!-- Formulario para enviar problemas con los vehiculos -->
    <form action="enviar_correo.php" method="post">
            <label for="lista">Seleccione un vehiculo:</label>
            <select name="lista" id="lista">
                <?php 
                    // Generar las opciones de la lista desplegable
                    while ($fila = mysqli_fetch_assoc($resultad)) {
                        echo "<option value='" . $fila['modelo'] . "'>" . $fila['patente'] . "</option>";
                    }

                    // Liberar los resultados y cerrar la conexión
                    mysqli_free_result($resultados);
                    mysqli_close($conexion);
                ?>
            </select>

            <br><br>

            <label for="problema">Describa su problema:</label>
            <textarea name="problema" id="problema" rows="4" cols="50"></textarea>

            <br><br>

            <input type="submit" value="Enviar">
    </form>



</body>
</html>