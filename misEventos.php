<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Mis eventos",
        "url" => "misEventos.php"
    ),
   
);

require "ConexionDB.php";

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

//obtener el id
$id = $_SESSION['id'];

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

$darMensaje = true;

if (isset($_POST['filtrar'])){
    if(!empty($_POST['fecha-hora'])){
        $fecha_hora = $_POST['fecha-hora'];
        $filtro = "DATE(fecha_inicio) = '".$fecha_hora."'";
        $darMensaje = false;
        $limite = "";
    } else {
        $filtro = "1";
        $limite = "limit 20";
    }
}else{
    $filtro = "1";
    $limite = "limit 20";
}

$sql = "SELECT * from eventos WHERE ".$filtro." AND id in (SELECT evento_id FROM eventoUsuarios where usuario_id = '".$id."') ORDER BY fecha_inicio DESC ".$limite;
$result = mysqli_query($conn, $sql);

$actualizarNotificacion="UPDATE notificaciones SET visto = true WHERE usuario_id = '".$id."'";
mysqli_query($conn, $actualizarNotificacion);

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>


<section class=" pt-5">
    <div class="container">
         <form class="d-inline"  method="post" style="vertical-align: center" action="">
            <label class=" d-inline" for="fecha-hora">Fecha:</label>
            <input class="form-date d-inline ms-2 pt-1 pb-1" type="date" id="fecha-hora" name="fecha-hora">
            <button type="submit" class="btn-general ms-2 px-3  d-inline" name="filtrar">
                <i class="bi bi-funnel fs-6 me-1"></i> Filtrar
            </button>
        </form>
        <div class="eventos mt-5 pt-2 text-left">
            <?php
    if (mysqli_num_rows($result) > 0){
        if ($darMensaje == true){
?>
            <h4 class="alert alert-info p-3 text-center">Ultimos eventos</h4>
            <?php
        }
?>
        <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Lugar</th>
            <th scope="col">Estado</th>
            </tr>
            </thead>
                <?php while ($row = mysqli_fetch_assoc($result)){ ?>
             <tr>
                 <td> <?php echo  $row['fecha_inicio'] ?> </td>
                 <td> <?php echo  $row['fecha_fin'] ?> </td>
                 <td> <?php echo  $row['lugar']  ?></td>
                <?php
                if ($row['fecha_fin'] < date("Y-m-d H:i:s")){
                ?>
                    <td>Finalizado</td>
                <?php
                } else {
                ?>
                    <td>Pendiente</td>
                <?php
                }
                ?>
            </tr>
                  
                <?php } ?>
        </table>
                
            <?php
    }else{
?>
            <h4 class="alert alert-secondary text-center">Sin eventos cargados</h4>
            <?php
    }
?>
        </div>
    </div>
</section>
<script src="js\eliminarEvento.js"></script>
<?php include('templates/footer.php')?>