<?php
// Breadcrumb Nav para Volver a la seccion anterior
$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Empleados",
        "url" => "empleados.php"
    ),
);

require("ConexionDB.php");

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

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

//consulta a la base de datos
$sql = "SELECT nombreApellido, dni , celular FROM `usuarios` ORDER BY nombreApellido ASC;";

//conectarse a la base de datos
$conn = connect();

$result = mysqli_query($conn, $sql);


include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>


<section class=" pt-5">
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
            <th scope=" col">Nombre</th>
            <th scope="col">DNI</th>
            <th scope="col">Celular</th>
            
            </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['nombreApellido']?></td>
                <td> <?php echo $row['dni'] ?></td>
                <td> <?php echo $row['celular'] ?></td>
                
            </tr>
            <?php } ?>
        </table>
    </div>
</section>
<?php include('templates/footer.php')?>