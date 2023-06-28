<?php
// Breadcrumb Nav para Volver a la seccion anterior
$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Usuario",
        "url" => "miUsuario.php"
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


$result = mysqli_query($conn, $sql);


include('templates/head.php');
include('templates/header.php');
include('templates/nav.php');
?>


<section class=" pt-5">
    <div class="container">
        <h2>Gomez Garese Lorenzo</h2>
        <p>lologg03@gmail.com</p>
        
    </div>
</section>
<?php include('templates/footer.php')?>