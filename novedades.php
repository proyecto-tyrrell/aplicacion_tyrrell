<?php
// Breadcrumb Nav para Volver a la seccion anterior
$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "RRHH",
        "url" => "RRHH.php"
    ),
);

include "ConexionDB.php";

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

$id = $_SESSION['id'];

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

//quitar notificacion
$actualizarNotificacion="UPDATE novedadUsuarios SET notificacion = true WHERE usuario_id = '".$id."'";
mysqli_query($conn, $actualizarNotificacion);

// Consulta SQL para obtener las últimas novedades
$sql = "SELECT * FROM novedades WHERE id IN ( SELECT novedad_id FROM novedadUsuarios WHERE usuario_id =  " .$_SESSION['id'] .") ORDER BY fecha_publicacion DESC LIMIT 15";
$result = mysqli_query($conn, $sql);

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class="pt-5">
    <div class="container">
        <h2 class="text-center">Novedades Recientes</h2>
        <div class="novedades">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="novedad border-bottom py-3">
                    <h3 class="text-center mb-3"><?php echo $row['titulo']; ?></h3>
                    <p class="text-center"><?php echo $row['contenido']; ?></p>
                    <p class="text-muted text-right" style="font-size: 12px;"><?php echo $row['fecha_publicacion']; ?></p>
                    <!-- Agrega opciones para mostrar contenido multimedia si es necesario -->
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include('templates/footer.php'); ?>