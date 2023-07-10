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
        "nombre" => "Editar",
        "url" => "editarEvento.php"
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

if (isset($_POST['eliminar'])) {
    $usuarios = isset($_POST['usuarios']) ? $_POST['usuarios'] : [];

    // eliminar usuarios seleccionados
    foreach ($usuarios as $usuario_id) {
        $sqlEliminar = "DELETE from eventoUsuarios WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $sqlEliminar);
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
                <h3>Usuarios</h3>
                <p>Seleccione los usuarios que desea eliminar del evento:</p>
                <form method="post">
                    <ul>
                        <?php
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)){ ?>
                        <li>
                            <div>
                                <label for="<?php echo $row['dni']; ?>"><?php echo $row['nombreApellido']; ?></label>
                                <input type="checkbox" id="<?php echo $row['dni']; ?>" name="usuarios[]" value="<?php echo $row['id']; ?>">
                            </div>
                        </li>
                        <?php
                        } 
                        ?>
                    </ul>
                    <button type="submit" class="btn-general " name="eliminar"><i class="bi bi-box-arrow-in-right  mx-1"></i> Eliminar</button>
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