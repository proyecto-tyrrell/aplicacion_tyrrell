<?php
// Breadcrumb Nav para Volver a la seccion anterior
$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Eventos",
        "url" => "eventos.php"
    ),
    array(
        "nombre" => "Asistencias",
        "url" => "asistencias.php"
    )
);

require("ConexionDB.php");

// Obtener los valores de inicio de sesión
session_start();

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];

// Verificar si el token de inicio de sesión está presente en la variable $_session
if (empty($_SESSION['token'])) {
    // Si no está el token de inicio de sesión, redirigir al index
    header('Location: index.php');
    exit;
}

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

$id = $_GET['id'];
$sql = "SELECT u.id, u.dni, u.nombreApellido FROM usuarios u JOIN eventoUsuarios eu on u.id = eu.usuario_id WHERE eu.evento_id = '".$id."'";

if (isset($_POST['confirmar-ingreso'])) {
    $usuariosSeleccionados = isset($_POST['usuariosIngreso']) ? $_POST['usuariosIngreso'] : [];

    // Cargar usuarios ingresados
    foreach ($usuariosSeleccionados as $usuario_id) {
        $sqlCargarIngreso = "UPDATE eventoUsuarios set ingreso = '".date('Y-m-d H:i:s')."' WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $sqlCargarIngreso);
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
    exit();
}

if (isset($_POST['confirmar-salida'])) {
    $usuariosSeleccionados = isset($_POST['usuariosSalida']) ? $_POST['usuariosSalida'] : [];

    // Cargar usuarios ingresados
    foreach ($usuariosSeleccionados as $usuario_id) {
        $sqlCargarSalida = "UPDATE eventoUsuarios set salida = '".date('Y-m-d H:i:s')."' WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $sqlCargarSalida);
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
    exit();
}

include('templates/head.php');
include('templates/header.php');
include('templates/nav.php');
?>


<section class=" pt-5">
    <div class="container">
        <div class="d-md-flex justify-content-center">
            <div class="mx-5 text-center asistencia">
                <h3>Confirmar ingreso</h3>
                <form method="post">
                    <ul>
                        <?php
                        $ingresoSql = $sql." and eu.ingreso is null";
                        $result = mysqli_query($conn, $ingresoSql);
                        while ($row = mysqli_fetch_assoc($result)){ ?>
                        <li>
                            <div>
                                <label for="<?php echo $row['dni']; ?>"><?php echo $row['nombreApellido']; ?></label>
                                <input type="checkbox" id="<?php echo $row['dni']; ?>" name="usuariosIngreso[]"
                                    value="<?php echo $row['id']; ?>">
                            </div>
                        </li>
                        <?php
                        } 
                        ?>
                    </ul>
                    <button type="submit" class="btn-general " name="confirmar-ingreso"><i
                            class="bi bi-box-arrow-in-right  mx-1"></i> ENTRADA</button>
                </form>
            </div>

            <div class="asistencia mx-5 text-center mt-5 mt-md-0">
                <h3>Confirmar salida</h3>
                <form method="post">
                    <ul>
                        <?php 
                        $salidaSql = $sql." and eu.ingreso is not null and eu.salida is null";
                        $result = mysqli_query($conn, $salidaSql);
                        while ($row = mysqli_fetch_assoc($result)){ ?>
                        <li>
                            <div>
                                <label for="<?php echo $row['dni']; ?>"><?php echo $row['nombreApellido']; ?></label>
                                <input type="checkbox" id="<?php echo $row['dni']; ?>" name="usuariosSalida[]" value="<?php echo $row['id'] ; ?>">
                            </div>
                        </li>
                        <?php
                        } 
                        ?>
                    </ul>
                    <button type="submit" class="btn-general-b" name="confirmar-salida"><i class="bi bi-box-arrow-in-left  mx-1"></i> SALIDA</button>
                </form>
            </div>
            <?php
            if (!empty($_GET['mensaje'])){
            ?>
            <div class="alert alert-success">
                <p>Se han confirmado los cambios</p>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<?php include('templates/footer.php') ?>