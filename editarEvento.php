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
$sqlEvento = "SELECT * FROM eventos WHERE id = ".$id;

$datosEvento = mysqli_fetch_assoc(mysqli_query($conn, $sqlEvento));

if (isset($_POST['eliminar'])) {
    $usuarios = isset($_POST['usuarios']) ? $_POST['usuarios'] : [];

    // eliminar usuarios seleccionados
    foreach ($usuarios as $usuario_id) {
        $sqlEliminar = "DELETE from eventoUsuarios WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $sqlEliminar);
        $actualizarNotificacion="DELETE from notificaciones WHERE evento_id = '".$id."' and usuario_id = '".$usuario_id."'";
        mysqli_query($conn, $actualizarNotificacion);
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
    exit();
}    

$sqlEvento= "SELECT * from eventos WHERE id = $id";
$evento = mysqli_fetch_assoc(mysqli_query($conn, $sqlEvento));

// usuarios
$sqlUsuarios = "SELECT * FROM usuarios WHERE id NOT IN (
    SELECT usuario_id FROM eventoUsuarios WHERE evento_id IN (
        SELECT id FROM eventos WHERE ('".$evento['fecha_inicio']."' <= fecha_inicio AND '".$evento['fecha_fin']."' >= fecha_inicio) OR ('".$evento['fecha_inicio']."' >= fecha_inicio AND '".$evento['fecha_inicio']."' <= fecha_fin)
    AND salida is null)
) ORDER BY nombreApellido";
$usuarios = mysqli_query($conn, $sqlUsuarios);

if ((isset($_POST['agregar'])) && (!empty($_POST['usuarios']))){
    $usuariosSeleccionados = $_POST['usuarios'];

    // Asignar usuarios al evento
    foreach ($usuariosSeleccionados as $usuario_id) {
        $sqlAsignarUsuario = "INSERT INTO eventoUsuarios (evento_id, usuario_id) VALUES ('$id', '$usuario_id')";
        mysqli_query($conn, $sqlAsignarUsuario);
        $sqlNotificacion = "INSERT INTO notificaciones (usuario_id, evento_id, visto) VALUES ('$usuario_id', '$id', false)";
        mysqli_query($conn, $sqlNotificacion);
    }
    header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
}

if (isset($_POST['modFecha'])){
    if ((!empty($_POST['fechaInicio'])) && (!empty($_POST['fechaFin']))){
        if ($_POST['fechaInicio'] < $_POST['fechaFin']){
            $inicio = $_POST['fechaInicio'];
            $fin = $_POST['fechaFin'];
            $sqlSetFecha = "UPDATE eventos SET fecha_inicio = '".$inicio."', fecha_fin = '".$fin."' WHERE id = ".$id;
            if (mysqli_query($conn, $sqlSetFecha)){
                header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
            } else {
                echo "Ha ocurrido un error con la base de datos";
            }
        } else {
            header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&fechaIncorrecta=true');
        }
    } else {
        header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&fechaIncorrecta=true');
    }
}

if (isset($_POST['modLugar'])){
    if (!empty($_POST['lugar'])){
        $lugar = $_POST['lugar'];
        $sqlSetLugar = "UPDATE eventos SET lugar = '".$lugar."' WHERE id = ".$id;
        if (mysqli_query($conn, $sqlSetLugar)){
            header('Location: '.$_SERVER['PHP_SELF'].'?id='.$id.'&mensaje=true');
        } else {
            echo "Ha ocurrido un error con la base de datos";
        }
    }
}

include('templates/head.php');
include('templates/header.php');
include('templates/nav.php');
?>


<section class=" pt-5">
    <?php
        if (!empty($_GET['mensaje'])){
        ?>
        <div class="alert alert-success text-center">
            <p>Se han confirmado los cambios</p>
        </div>
        <?php
        }
    ?>
    <div class="container">
        <div class="d-md-flex justify-content-center">
            <div class="mx-5 text-center asistencia">
                <div>
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
                <div>
                    <p>Seleccione los usuarios que desea agregar al evento:</p>
                    <form method="post">
                        <div>
                            <select id="multiple-checkboxes2" name="usuarios[]" multiple>
                                <?php
                                while ($U = mysqli_fetch_assoc($usuarios)){
                                ?>
                                    <option id="<?php echo $U['dni']; ?>" value="<?php echo $U['id']; ?>"><?php echo $U['nombreApellido']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-general px-4" name="agregar" id="agregar"><i class="bi bi-box-arrow-in-right  mx-1"></i> Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="fechaYHora" class="container">
        <div class="d-md-flex justify-content-center">
            <div class="mx-5 text-center asistencia">
                <h3>Fecha y hora</h3>
                <form method="post">
                    <div>
                        <label for="fechaInicio">Seleccione la nueva fecha y hora de inicio del evento:</label>
                        <input class="form-control" id="fechaInicio" name="fechaInicio" type="datetime-local" value="<?php echo $datosEvento['fecha_inicio']; ?>">
                    </div>
                    <div>
                        <label for="fechaFin">Seleccione la nueva fecha y hora de inicio del evento:</label>
                        <input class="form-control" id="fechaFin" name="fechaFin" type="datetime-local" value="<?php echo $datosEvento['fecha_fin']; ?>">
                    </div>
                    <button type="submit" class="btn-general px-4" name="modFecha" id="modFecha"><i class="bi bi-box-arrow-in-right  mx-1"></i> Modificar </button>
                </form>
                <?php
                    if (!empty($_GET['fechaIncorrecta'])){
                    ?>
                    <div class="alert alert-danger text-center">
                        <p>Ingrese fechas validas</p>
                    </div>
                    <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <div id="lugar" class="container">
        <div class="d-md-flex justify-content-center">
            <div class="mx-5 text-center asistencia">
            <h3>Lugar</h3>
            <form method="post">
                    <div>
                        <label for="lugar">Seleccione la nueva ubicacion del evento:</label>
                        <input class="form-control" id="lugar" name="lugar" type="text" value="<?php echo $datosEvento['lugar']; ?>">
                    </div>
                    <button type="submit" class="btn-general px-4" name="modLugar" id="modLugar"><i class="bi bi-box-arrow-in-right  mx-1"></i> Modificar </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include('templates/footer.php') ?>