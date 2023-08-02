<?php
// Breadcrumb Nav para Volver a la seccion anterior
$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Solicitudes",
        "url" => "solicitudes.php"
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
}

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

//QUERY
$sql = "SELECT nombre from proyectos WHERE activo = true order by nombre ASC ;";

$result = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enviarCorreo();
}
include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>


<section class=" pt-5">
    <div class="container">
        <!-- FORMULARIO -->

        <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group col-md-6">

                <label class="mb-3" for="lista">Seleccione un proyecto si es lo que tiene:</label>
                <select name="lista" id="lista" class="form-select fs-4">
                    <?php
        while ($fila = mysqli_fetch_assoc($result)) {
        ?>
                    <option value="<?php echo $fila['nombre']; ?>"><?php echo $fila['nombre']; ?></option>";
                    <?php
        }

        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
                </select>
                <br><br>

                <label class="mb-3" for="solicitud">Solicito la cantidad de dinero para:</label>
                <textarea class="form-control" name="mensaje" id="mensaje" rows="4" cols="50" required></textarea>


                <button type="submit" class="btn-general pt-2 pb-2 px-4 text-uppercase mt-3">Enviar</button>
            </div>
        </form>
    </div>
    <div class="col-md-12 mt-4">
        <?php
            if( isset($_GET['enviado'])){
                if ($_GET['enviado'] === true){
        ?>
                    <p class="alert alert-success text-center">Correo enviado correctamente</p>
        <?php
                }else{
        ?>
                    <p class="alert alert-danger  text-center">Error al enviar el correo</p>
        <?php
                }
            }

        function enviarCorreo()
        {
            // Verificar si se recibieron los datos del formulario
            if (!empty($_POST['lista']) && !empty($_POST['mensaje'] )) {
                // Obtener los valores del formulario
                $elemento = $_POST['lista'];
                $solicitud = $_POST['mensaje'];
        
                // Dirección de correo a la que se enviará el mensaje
                $destinatario = "administracion@tyrrell.com.ar";
        
                // Asunto del correo
                $asunto = "Solicitud de dinero";
        
                // Construir el mensaje
        
                $mensaje = "Elemento seleccionado: " . $elemento . "\n";
                $mensaje .= "Solicitud: " . $solicitud ;
        
                //Cabeceras del correo (correo del remitente)
                $cabeceras = "De: " . $nombre_usuario;
        
        
        
                // Enviar el correo electrónico
                if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
                    'Location: '.$_SERVER['PHP_SELF'].'?mensaje=true';
                } else {
                    'Location: '.$_SERVER['PHP_SELF'].'?enviado=false';
                }
            } else {
            ?>
                <p class="alert alert-danger  text-center">Error: no se recibieron los datos del formulario.</p>
            <?php
            }
        }    
        ?>
    </div>
</section>
<?php include('templates/footer.php')?>