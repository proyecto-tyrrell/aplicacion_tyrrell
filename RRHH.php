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
} else {
    if ($_SESSION['rol'] !== "adm") {
        header('Location: principal.php');
        exit;
    }
}

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

$sqlUsuarios = "SELECT * FROM usuarios ORDER BY nombreApellido";
$usuarios = mysqli_query($conn, $sqlUsuarios);

//mensajes en pantalla
$cargadoCorrectamente = false;
$error = false;
$todosLosCampos = false;

if (isset($_POST['guardar'])) {
    if (!empty($_POST['titulo']) && !empty($_POST['contenido']) && !empty($_POST['usuarios'])) {
        // Procesar el formulario de creación de novedades
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $fecha_publicacion = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

        // Realizar la inserción en la base de datos
        $sql = "INSERT INTO novedades (titulo, contenido, fecha_publicacion) VALUES ('$titulo', '$contenido', '$fecha_publicacion')";
        if (mysqli_query($conn, $sql)) {
            $novedad_id = mysqli_insert_id($conn); //obtener el id de la novedad creada

            // Procesar la selección de usuarios (guardar en la tabla eventoUsuarios)
            if (!empty($_POST['usuarios'])) {
                foreach ($_POST['usuarios'] as $usuario_id) {
                    $sqlPorUsuario = "INSERT INTO novedadUsuarios (usuario_id, novedad_id, notificacion) VALUES ('".$usuario_id."', '".$novedad_id."', false)";
                    mysqli_query($conn, $sqlPorUsuario);
                }
            }
            $cargadoCorrectamente = true;
        } else {
            // Mostrar un mensaje de error si la inserción falla
            $error = true;
        }
    }else{
        $todosLosCampos = true;
    }
}

include('templates/head.php')
    ?>

<?php include('templates/header.php') ?>
<?php include('templates/nav.php') ?>

<section class="pt-5">
    <div class="container">
        <h2>Crear Nueva Novedad</h2>
        <div class="container">
            <div class="text-center mt-3">
                <button class="btn btn-primary" id="botonModal" data-toggle="modal" data-target="#myModal">Abrir Lista de Empleados</button>
            </div>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="4" required></textarea>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Selecciona los Empleados</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <button class="btn btn-primary my-2" onclick="selectAll()">Seleccionar todos</button>
                            <div class="row">
                                <?php
                                $counter = 0;
                                while ($U = mysqli_fetch_assoc($usuarios)) {
                                    if ($counter % 6 == 0) {
                                        ?></div><div class="row"><?php
                                    }
                                    ?>
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="usuarios[]" value="<?php echo $U['id']; ?>" id="usuario_<?php echo $U['id']; ?>">
                                            <label class="form-check-label" for="usuario_<?php echo $U['id']; ?>"><?php echo $U['nombreApellido']; ?></label>
                                        </div>
                                    </div>
                                    <?php
                                    $counter++;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
        </form>
        
        <?php
            if ($cargadoCorrectamente){ ?>
                <p class="alert alert-success text-center my-3" >Se ha cargado con éxito</p>
            <?php }
            if ($error ) { ?>
                <p class="alert alert-danger  text-center my-3">Ha ocurrido un error</p>
            <?php }
            if ($todosLosCampos){ ?>
                <p class="alert alert-danger  text-center my-3">Ha ocurrido un error</p>
            <?php }
        ?>
    </div>
</section>

<script src="js\seleccionarTodos.js"></script>
<?php include('templates/footer.php'); ?>