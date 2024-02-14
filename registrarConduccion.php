<?php

require("ConexionDB.php");

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

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

//obtener ususario id
$id = $_SESSION['id'];

$completar = false;

function vehiculoValido($vehiculo){
    global $conn;
    $sqlVehiculoValido = "SELECT * FROM vehiculos WHERE patente = '".$vehiculo."'";
    $result = mysqli_query($conn , $sqlVehiculoValido);
    if (mysqli_num_rows($result) == 1){
        return true;
    }else{
        return false;
    }
}

function enviarCorreo()
{
    // Verificar si se recibieron los datos del formulario
    if (!empty($_POST['observacion'])) {
        global $conn;

        // Obtener los valores del formulario
        $elemento = $_GET['vehiculo'];
        $problema = $_POST['observacion'];
        
        //obtener datos del vehiculo;
        $vehiculoSql = "SELECT * from vehiculos WHERE patente = '". $elemento ."'";
        $vehiculoResult = mysqli_query($conn, $vehiculoSql);
        $vehiculo = mysqli_fetch_assoc($vehiculoResult);

        // Dirección de correo a la que se enviará el mensaje
        $destinatario = "hnetto@tyrrell.com.ar";

        //asunto
        $asunto = "Problema con vehículo";

        // Construir el mensaje
        
        
        $mensaje = "Elemento seleccionado: " . $vehiculo['modelo'] . ", " .$elemento. ". \n";
        $mensaje .= "Problema: " . $problema . ". \n" ;
        $mensaje .= "usuario: " . $_SESSION['nombre'] . ".";

        //Cabeceras del correo (correo del remitente)
        $remitente = "tyrrell@aplicacion.desarrollo-tyrrell.com";
        $cabeceras = "From: " . $remitente . "\r\n";

        $resultado = mail($destinatario, $asunto, $mensaje, $cabeceras);

        //enviar mail a otro correo

        $destinatario = "lologg03@gmail.com";
        mail($destinatario, $asunto, $mensaje, $cabeceras);

        // Enviar el correo electrónico
        if ($resultado) {
            $insertarSql = "INSERT INTO mensajeVehiculos (vehiculo_id, usuario_id, mensaje, fecha) VALUES ('".$vehiculo['id']."', '".$_SESSION['id']."', '".$problema."' , '".date('Y-m-d H:i:s')."')";
            mysqli_query($conn, $insertarSql);
        } else {
            header('Location: '.$_SERVER['PHP_SELF']);
            exit;
        }
    }
}

if (isset($_POST['confirmar'])){
    if (vehiculoValido($_GET['vehiculo']) == true){

        if (!empty($_POST['proyecto']) && !empty($_POST['kilometraje'])){
            enviarCorreo();
            $sqlKilometraje = "UPDATE vehiculos SET kilometraje = '".$_POST['kilometraje']."' WHERE patente = '".$_GET['vehiculo']."'";
            mysqli_query($conn, $sqlKilometraje);

            $sqlProyecto = "INSERT INTO vehiculoProyecto (vehiculo_id, proyecto_id, fecha) values ((SELECT id FROM vehiculos WHERE patente = '".$_GET['vehiculo']."'), ".$_POST['proyecto'].", '".date('Y-m-d H:i:s')."')";
            mysqli_query($conn, $sqlProyecto);

            $sqlUsuarioVehiculo = "INSERT INTO usuarioVehiculo (usuario_id, vehiculo_id, fecha) values (".$id.", (SELECT id FROM vehiculos WHERE patente = '".$_GET['vehiculo']."'), '".date('Y-m-d H:i:s')."')";
            mysqli_query($conn, $sqlUsuarioVehiculo);


            header("Location: principal.php?conduccion=true");
        }else{
            $completar = true;
        }
    }
}


include('templates/head.php')
?>
<?php include('templates/header.php');?>

<section class="pt-md-4">
<div class="container">
    <?php
    if (!vehiculoValido($_GET['vehiculo'])){ ?>
        <div class="text-center">
            <h1>Vehiculo invalido</h1>

            <h3>Por favor vuelva a escanear el código qr</h3>
        </div>

    <?php
    }else{
        
        $sqlProyectos = "SELECT * FROM proyectos WHERE activo = true order by codigo";
        $proyectos = mysqli_query($conn, $sqlProyectos);
    ?>

        <h1 class="text-center"><?php echo $_GET['vehiculo'];?></h1>

        <form method="post" style="vertical-align: center">
            <div class="mt-3">
                <label for="proyecto">Proyecto:</label>
                <select name="proyecto" id="proyecto" class="fs-5 form-select p-3 px-3" required>
                    <option value="" selected disabled>Seleccione un proyecto</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($proyectos)){ ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['codigo'].", ".$row['nombre']?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="mt-3">
                <label for="kilometraje">Kilometraje:</label>
                <input id="kilometraje" name="kilometraje" type="number" placeholder="Kilometraje" class="form-control" required>
            </div>
            
            <div class="mt-3">
                <label for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion" placeholder="Observación" class="form-control"></textarea>
            </div>

            <div class="md-12 mt-5 text-center">
                <button class="btn btn-primary" type="submit" name="confirmar">Registrar conduccion</button>
            </div>
        </form>
    
    <?php 
    }
        if ($completar == true){ ?>
            <p class="alert alert-danger  text-center mt-3">
                Por favor complete todos los datos requeridos
            </p>
        <?php } 
    ?>
</div>
</section>
<script src="js\notificacion.js"></script>
<?php
    include('templates/footer.php')
?>
