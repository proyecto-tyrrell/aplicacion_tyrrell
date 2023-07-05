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
        "nombre" => "Nuevo evento",
        "url" => "agregarEvento.php"
    )
);

require "ConexionDB.php";

// obtener los valores de inicio de sesion
session_start();

// verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    // si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}
// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];

// conectarse a la base de datos
$conn = connect();

// proyectos
$sqlProyectos = "SELECT * FROM proyectos ORDER BY codigo";
$proyectos = mysqli_query($conn, $sqlProyectos);

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>


<section class=" pt-5">
    <div class="container">
        <form class="formularios" method="post" id="form-agregar-evento-1">
            <div class="m-2 mx-0">
                <label for="proyecto">Proyecto:</label>
                <select name="proyecto" id="proyecto" class="fs-5 form-select p-3 px-3" required>
                    <option value="" selected disabled>Seleccione un proyecto</option>
                    <?php
                while ($P = mysqli_fetch_assoc($proyectos)){
                    ?>
                    <option value="<?php echo $P['id']; ?>"><?php echo $P['codigo']; ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="m-4 mx-0">
                <label for="fecha-inicio">Fecha y hora de inicio:</label>
                <input class="form-control" type="datetime-local" id="fecha-inicio" name="fecha-inicio" required>
            </div>
            <div class="m-4 mx-0">
                <label for="fecha-fin">Fecha y hora de fin:</label>
                <input class="form-control" type="datetime-local" id="fecha-fin" name="fecha-fin" required>
            </div>
            <div>
                <label for="lugar">Lugar:</label>
                <input class="form-control" type="text" id="lugar" name="lugar" required>
            </div>
            <div class="m-4 mx-0">
                <button type="submit" class="btn-general px-3" name="siguiente">Siguiente</button>
            </div>
        </form>

        <?php
    if (isset($_POST['siguiente'])){
        if ((!empty($_POST['proyecto'])) && (!empty($_POST['fecha-inicio'])) && (!empty($_POST['fecha-fin'])) && (!empty($_POST['lugar']))){
            $proyecto_id = $_POST['proyecto'];
            $fecha_inicio = $_POST['fecha-inicio'];
            $fecha_fin = $_POST['fecha-fin'];
            $lugar = $_POST['lugar'];

            //insertar
            $sql = "INSERT INTO eventos (usuario_id, proyecto_id, fecha_inicio, fecha_fin, lugar) VALUES ('".$_SESSION['id']."', '".$proyecto_id."', '".$fecha_inicio."', '".$fecha_fin."', '".$lugar."')";
            mysqli_query($conn, $sql);
            $evento_id = mysqli_insert_id($conn);//obtener id del evento recien creado

            // vehiculos
            $sqlVehiculos = "SELECT * FROM vehiculos WHERE id NOT IN (
                SELECT vehiculo_id FROM eventoVehiculos WHERE evento_id IN (
                    SELECT id FROM eventos WHERE ('".$fecha_inicio."' <= fecha_inicio AND '".$fecha_fin."' >= fecha_inicio) OR ('".$fecha_inicio."' >= fecha_inicio AND '".$fecha_inicio."' <= fecha_fin)
                )
            ) ORDER BY modelo";
            $vehiculos = mysqli_query($conn, $sqlVehiculos);

            // usuarios
            $sqlUsuarios = "SELECT * FROM usuarios WHERE id NOT IN (
                SELECT usuario_id FROM eventoUsuarios WHERE evento_id IN (
                    SELECT id FROM eventos WHERE ('".$fecha_inicio."' <= fecha_inicio AND '".$fecha_fin."' >= fecha_inicio) OR ('".$fecha_inicio."' >= fecha_inicio AND '".$fecha_inicio."' <= fecha_fin)
                )
            ) ORDER BY nombreApellido";
            $usuarios = mysqli_query($conn, $sqlUsuarios);
            ?>
        <script>
        document.getElementById("form-agregar-evento-1").style.display = "none";
        </script>

        <form method="post" id="form-agregar-evento-2">
            <div class="d-md-flex justify-content-start">

                <div class="me-5">
                    <h3>Vehiculos:</h3>
                    <select id="multiple-checkboxes" name="vehiculos[]" multiple>

                        <?php
                        while ($V = mysqli_fetch_assoc($vehiculos)){
                        ?>
                        <option id="<?php echo $V['patente']; ?>" value="<?php echo $V['id']; ?>"><?php echo $V['modelo'].", ".$V['patente']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <h3>Usuarios:</h3>
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
            </div>
            <div class="m-5 mx-0">
                <input class="form-control" type="hidden" name="evento_id" value="<?php echo $evento_id; ?>">
                <button type="submit" class="btn-general px-4" name="cargar">Cargar</button>
            </div>

        </form>
        <?php
        }else{
            ?>
        <p class="alert alert-danger  text-center">Debe ingresar todos los campos</p>
        <?php
        }
    }

    if ((isset($_POST['cargar'])) && (!empty($_POST['usuarios']))){
        $evento_id = $_POST['evento_id'];

        if (!empty($_POST['vehiculos'])){
            $vehiculosSeleccionados = $_POST['vehiculos'];

            // Asignar vehículos al evento
            foreach ($vehiculosSeleccionados as $vehiculo_id) {
            // echo $vehiculo_id;
                $sqlAsignarVehiculo = "INSERT INTO eventoVehiculos (evento_id, vehiculo_id) VALUES ('$evento_id', '$vehiculo_id')";
                mysqli_query($conn, $sqlAsignarVehiculo);
            }
        }            

        $usuariosSeleccionados = $_POST['usuarios'];

        // Asignar usuarios al evento
        foreach ($usuariosSeleccionados as $usuario_id) {
            //echo $usuario_id;
            $sqlAsignarUsuario = "INSERT INTO eventoUsuarios (evento_id, usuario_id) VALUES ('$evento_id', '$usuario_id')";
            mysqli_query($conn, $sqlAsignarUsuario);
        }
        ?>
        <p class="alert alert-success text-center" >Se ha cargado con éxito</p>
        <?php
    }      
    ?>
    </div>
</section>
<script src="mensajeError.js"></script>
<?php include('templates/footer.php')?>