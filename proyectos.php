<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Proyectos",
        "url" => "proyectos.php"
    ),
   
);

require "ConexionDB.php";

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

//consulta a la base de datos
$sql = "SELECT * FROM proyectos WHERE 1";

//conectarse a la base de datos
$conn = connect();

$result = mysqli_query($conn, $sql);
include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">
        <div class="text-end">
            <?php
    if ($_SESSION['rol'] == 'adm'){
?>
            <a href="agregarProyecto.php" class="btn-general">
                <i class="bi bi-plus-circle-fill fs-7 me-1"></i> Nuevo proyecto
            </a>
            <?php
    }
?>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope=" col">Código</th>
                    <th scope="col">Nombre</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td> <?php echo $row['codigo']?> </td>
                <td> <?php echo $row['nombre'] ?></td>


                <?php } ?>
            </tr>
        </table>

    </div>
</section>
<?php include('templates/footer.php')?>
