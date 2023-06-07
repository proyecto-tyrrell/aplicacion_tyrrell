<?php
require "ConexionDB.php";

// obtener los valores de inicio de sesion
session_start();

// verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    // si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}

// conectarse a la base de datos
$conn = connect();

// proyectos
$sqlProyectos = "SELECT * FROM proyectos ORDER BY codigo";
$proyectos = mysqli_query($conn, $sqlProyectos);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - usuario</title>
    <link rel="stylesheet" href="estilos\Style.css">
</head>
<body>
    <header>
        <a href="principal.php" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
    </header>
    <nav id="sidebar">
        <button id="desplegar"></button>
        <ul>
            <li><a href="index.php">Cerrar sesion</a></li>
        </ul>
    </nav>
    <form method="post" id="form-agregar-evento-1">
        <div>
            <label for="proyecto">Proyecto:</label>
            <select name="proyecto" id="proyecto" required>
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
        <div>
            <label for="fecha-inicio">Fecha y hora de inicio:</label>    
            <input type="datetime-local" id="fecha-inicio" name="fecha-inicio" required>
        </div>
        <div>
            <label for="fecha-fin">Fecha y hora de fin:</label>    
            <input type="datetime-local" id="fecha-fin" name="fecha-fin" required>
        </div>
        <div>
            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" required>
        </div>
        <div>
            <button type="submit" class="btn" name="siguiente">Siguiente</button>
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
            <form method="post" id="form-agregar-evento-2">
                <div>
                    <h3>Vehiculos:</h3>
                    <?php
                    while ($V = mysqli_fetch_assoc($vehiculos)){
                        ?>
                        <label for="<?php echo $V['patente']; ?>"><?php echo $V['modelo'].", ".$V['patente']; ?></label>
                        <input type="checkbox" id="<?php echo $V['patente']; ?>" name="vehiculos[]" value="<?php echo $V['id']; ?>">
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <h3>Usuarios:</h3>
                    <?php
                    while ($U = mysqli_fetch_assoc($usuarios)){
                        ?>
                        <label for="<?php echo $U['dni']; ?>"><?php echo $U['nombreApellido']; ?></label>
                        <input type="checkbox" id="<?php echo $U['dni']; ?>" name="usuarios[]" value="<?php echo $U['id']; ?>">
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <input type="hidden" name="evento_id" value="<?php echo $evento_id; ?>">
                    <button type="submit" class="btn" name="cargar">Cargar</button>
                </div>            
            </form>
            <?php
        }else{
            ?>
            <p>Debe ingresar todos los campos</p>
            <?php
        }
    }

    if (isset($_POST['cargar'])){
        $evento_id = $_POST['evento_id'];
        $vehiculosSeleccionados = isset($_POST['vehiculos']) ? $_POST['vehiculos'] : [];
        $usuariosSeleccionados = isset($_POST['usuarios']) ? $_POST['usuarios'] : [];

        // Asignar vehículos al evento
        foreach ($vehiculosSeleccionados as $vehiculo_id) {
            $sqlAsignarVehiculo = "INSERT INTO eventoVehiculos (evento_id, vehiculo_id) VALUES ('$evento_id', '$vehiculo_id')";
            mysqli_query($conn, $sqlAsignarVehiculo);
        }

        // Asignar usuarios al evento
        foreach ($usuariosSeleccionados as $usuario_id) {
            $sqlAsignarUsuario = "INSERT INTO eventoUsuarios (evento_id, usuario_id) VALUES ('$evento_id', '$usuario_id')";
            mysqli_query($conn, $sqlAsignarUsuario);
        }
        ?>
        <p>Se ha cargado con éxito</p>
        <?php
    }
    ?>
    <script src="desplegable.js"></script>
</body>
</html>