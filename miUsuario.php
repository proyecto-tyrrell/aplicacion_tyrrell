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
$id = $_SESSION['id'];

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

//consulta a la base de datos
$sql = "SELECT * FROM usuarios WHERE id = '".$id."'";
$result = mysqli_query($conn, $sql);
$usuario = mysqli_fetch_assoc($result);


include('templates/head.php');
include('templates/header.php');
include('templates/nav.php');
?>


<section class=" pt-5">
    <div id="datos" class="container">
        <h2><?php echo $nombre_usuario; ?></h2>
        <p><?php echo $usuario['dni']; ?></p>
        <p><?php echo $usuario['mail']; ?></p>
        <p><?php echo $usuario['celular']; ?></p>
        <button onclick="mostrarForm()" class="btn-general mt-1">Cambiar contraseña</button>
    </div>

    <div id="form" class="no-mostrar">
        <form method="post" id="cambiarPass" class="container">
            <div class="m-2 mx-0">
                <label for="pass1">Introduzca su nueva contraseña:</label>
                <input class="form-control" id="pass1" name="pass1" type="text" required>
            </div>
            <div class="m-2 mx-0">
                <label for="pass2">Confirmar contraseña:</label>
                <input class="form-control" id="pass2" name="pass2" type="text" required>
            </div>
            <div>
                <button type="button" onclick="ocultarForm()" class="btn-general mt-1">Cancelar</button>
                <button id="confirmar" name="confirmar" type="submit" class="btn-general mt-1">Confirmar</button>
            </div>
        </form>
    </div>
</section>
<?php
    if (isset($_POST['confirmar'])){
        if ($_POST['pass1'] == $_POST['pass2']){
        ?>
            <p class="alert alert-success text-center" >Se ha cargado con éxito</p>
        <?php
        }
    }
?>
<script src="js\cambiarPass.js"></script>
<?php include('templates/footer.php')?>