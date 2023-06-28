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

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">

        <form method="post">
            <div class="col-md-6">
                <label for="nombre">Nombre del proyecto:</label>
                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="col-md-6">
                <label for="codigo">Codigo del proyecto:</label>
                <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Codigo" required>
            </div>
            <div class="col-md-12 mt-5">
                <button type="submit" class="btn-general" name="agregar">Agregar proyecto</button>
            </div>
       
        <?php
    if (isset($_POST['agregar'])){
        if(!empty($_POST['nombre']) and !empty($_POST['codigo'])){
            $nombre = $_POST['nombre'];
            $codigo = $_POST['codigo'];
            //consulta a la base de datos
            $sql = "INSERT INTO proyectos (nombre, codigo) VALUES ('".$nombre."', '".$codigo."')";
            try{
                mysqli_query($conn, $sql)
            ?>
        <p class="alert alert-success text-center ">
            Se ha agregado correctamente
        </p>
        <?php
            }catch(EXCEPTION $e){
            ?>
        <p class="alert alert-danger  text-center">
            Ha ocurrido un error, por favor intentelo mas tarde
        </p>
         </form>
        <?php
            }
        }
    }
    
?>
 </form>
    </div>
</section>
<?php include('templates/footer.php')?>
