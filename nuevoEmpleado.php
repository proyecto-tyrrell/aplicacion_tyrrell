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
    array(
        "nombre" => "Nuevo empleado",
        "url" => "nuevoEmpleado.php"
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
}else{
    if ($_SESSION['rol'] !== "adm" && $_SESSION['rol'] !== "coord"){
        header('Location: principal.php');
        exit;
    } 
}

//conectarse a la base de datos
$conn = connect();

$sqlCargos = "SELECT DISTINCT cargo FROM usuarios WHERE cargo <> ''";
$cargos = mysqli_query($conn, $sqlCargos);

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">

        <form method="post">
            <div class="col-md-6">
                <label for="nombre">Apellido y nombre:</label>
                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="col-md-6">
                <label for="dni">Dni:</label>
                <input class="form-control" type="text" id="dni" name="dni" placeholder="Dni" required>
            </div>
            <div class="col-md-6">
                <label for="cel">Celular:</label>
                <input class="form-control" type="tel" id="cel" name="cel" placeholder="Celular" required>
            </div>
            <div class="col-md-6">
                <label for="mail">Correo electrónico:</label>
                <input class="form-control" type="email" id="mail" name="mail" placeholder="Correo electrónico" required>
            </div>
            <div class="col-md-6">
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" class="fs-5 form-select p-3 px-3" required>
                    <option value="" selected disabled>Seleccione una categoria</option>
                    <option value="adm" selected>Administrador</option>
                    <option value="usuario" selected>Usuario</option>
                    <option value="coord" selected>Coordinador</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="cargo">Cargo:</label>
                <select name="cargo" id="cargo" class="fs-5 form-select p-3 px-3" required>
                    <option value="" selected disabled>Seleccione un cargo</option>
                    <?php
                while ($C = mysqli_fetch_assoc($cargos)){
                    ?>
                    <option value="<?php echo $C['cargo']; ?>"><?php echo $C['cargo']; ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="col-md-12 mt-5">
                <button type="submit" class="btn btn-primary" name="agregar">Agregar Empleado</button>
            </div>
        </form>
    </div>
</section>

<section class=" pt-5">
<div class="container">
<?php
    if (isset($_POST['agregar'])){
        if(!empty($_POST['nombre']) and !empty($_POST['dni']) and !empty($_POST['mail']) and !empty($_POST['categoria']) and !empty($_POST['cargo']) and !empty($_POST['cel'])){
            $dni = $_POST['dni'];
            $buscarDni="SELECT * FROM usuarios WHERE dni = ".$dni ;
            $resultados = mysqli_fetch_assoc(mysqli_query($conn, $buscarDni));
            if ($resultados < 1) {
                $nombre = $_POST['nombre'];
                $mail = $_POST['mail'];
                $categoria = $_POST['categoria'];
                $cargo = $_POST['cargo'];
                $cel = $_POST['cel'];

                //consulta a la base de datos
                //se crea el usuario con el dni de nombre de usuario y pass
                $sql = "INSERT INTO usuarios (nombreApellido, dni, mail, pass, categoria, cargo, celular) VALUES ('".$nombre."', '".$dni."', '".$mail."', '".$dni."', '".$categoria."', '".$cargo."', '".$cel."')";
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
            <?php
                }
            }else{
                ?>
                <p class="alert alert-danger  text-center">
                        El usuario ya se encuentra cargado
                </p>
                <?php
            }
        }
    }
?>
</div>
</section>
<?php include('templates/footer.php')?>
