<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Vehiculos",
        "url" => "vehiculos.php"
    ),
    array(
        "nombre" => "Reportar problema",
        "url" => "problemaVehiculo.php"
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

//QUERY
$sql = "SELECT modelo, patente from vehiculos order by modelo ASC ;";

$result = mysqli_query($conn , $sql);
include('templates/head.php');

function enviarCorreo()
{
    // Verificar si se recibieron los datos del formulario
    if (!empty($_POST['lista']) && !empty($_POST['mensaje'] )) {
        $conn = connect();

        // Obtener los valores del formulario
        $elemento = $_POST['lista'];
        $problema = $_POST['mensaje'];
        
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
            header('Location: '.$_SERVER['PHP_SELF'].'?enviado=true');
            exit;
        } else {
            header('Location: '.$_SERVER['PHP_SELF'].'?enviado=false');
            exit;
        }
        
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enviarCorreo();
}

?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">
        <!-- Seleccion de auto -->

        <!-- Formulario para enviar problemas con los vehiculos -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             <div class="col-md-6 me-md-2">
                <label for="lista">Seleccione un vehiculo:</label>
                <select class="form-select fs-4" name="lista" id="lista" required>
                    <?php 
                    // Generar las opciones de la lista desplegable
                    while ($fila = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $fila['patente'] ; ?>"><?php echo $fila['patente'] ; ?></option>;
                    <?php }
                ?>

                </select>
            </div>
            <div class="col-md-6  mt-4">
                <label for="problema">Describa su problema:</label>
                <textarea class="form-control" name="mensaje" id="problema" rows="4" cols="50" required></textarea>
            </div>
            <div class="col-md-12 mt-4">
                <button class="btn-general" type="submit">Enviar</button>
            </div>

        </form>
    </div>
    <div class="col-md-12 mt-4">
        <?php
            if( isset($_GET['enviado'])){
                if ($_GET['enviado'] == true){
        ?>
                    <p class="alert alert-success text-center">Correo enviado correctamente</p>
        <?php
                }else{
        ?>
                    <p class="alert alert-danger  text-center">Error al enviar el correo</p>
        <?php
                }
            }
        ?>
    </div>
</section>
<?php include('templates/footer.php')?>
