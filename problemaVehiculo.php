<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Vehiculos",
        "url" => "vehiculos.php"
    ),
    array(
        "nombre" => "Reportar problema",
        "url" => "problemaVehiculo.php"
    ),
   
);
require "ConexionDB.php";

//obtener los valores de inicio de sesion
session_start();
// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];
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
include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">
        <!-- Seleccion de auto -->

        <!-- Formulario para enviar problemas con los vehiculos -->
        <form action="enviar_correo.php" method="post">
             <div class="col-md-6 me-md-2">
                <label for="lista">Seleccione un vehiculo:</label>
                <select class="form-select fs-4" name="lista" id="lista">
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
            </div>
            <div class="col-md-6  mt-4">
                <label for="problema">Describa su problema:</label>
                <textarea class="form-control" name="problema" id="problema" rows="4" cols="50"></textarea>
            </div>
            <div class="col-md-12 mt-4">
                <button class="btn-general" type="submit">Enviar</button>
            </div>

        </form>

    </div>
</section>
<?php include('templates/footer.php')?>
