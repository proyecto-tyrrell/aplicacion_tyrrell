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
   
);

require "ConexionDB.php";

//obtener los valores de inicio de sesion
session_start();

//verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    //si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}else{
    if ($_SESSION['rol'] !== "adm" && $_SESSION['rol'] !== "coord"){
        header('Location: principal.php');
        exit;
    } 
}

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];

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

$sql = "SELECT * from eventos WHERE ".$filtro." ORDER BY fecha_inicio DESC ". $limite;
$result = mysqli_query($conn, $sql);

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>


<section class=" pt-5">
    <div class="container">

                <form class="d-inline"  method="post" style="vertical-align: center" action="">
                    <label class=" d-inline" for="fecha-hora">Fecha:</label>
                    <input class="form-date d-inline ms-2 pt-1 pb-1" type="date" id="fecha-hora"
                        name="fecha-hora">

                    <button type="submit" class="btn-general ms-2 px-3  d-inline" name="filtrar">
                        <i class="bi bi-funnel fs-6 me-1"></i> Filtrar
                    </button>
                </form>
            <?php if (($_SESSION['rol'] == 'adm') or ($_SESSION['rol'] == 'coord')){?>
             <div class=" d-md-inline float-md-end mt-5 mt-md-0 text-center">
                <a href="agregarEvento.php?nombre=Eventos%20»%20Nuevo">
                    <button class="btn-general">
                        <i class="bi bi-plus-circle-fill fs-7 me-1"></i> Nuevo evento
                    </button>
                </a>
            </div>
        <?php
    }
?>
        <div class="eventos mt-5 pt-2 text-left">
            <?php
    if (mysqli_num_rows($result) > 0){
        if ($darMensaje == true){
?>
            <h4 class="alert alert-info p-3 text-center">Ultimos eventos </h4>
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
                } elseif (($row['fecha_inicio'] <= date("Y-m-d H:i:s")) && ($row['fecha_fin'] >= date("Y-m-d H:i:s"))){
                ?>
                    <td>En curso</td>
                <?php
                } elseif ($row['fecha_inicio'] > date("Y-m-d H:i:s")) {
                ?>
                    <td>Pendiente</td>
                <?php
                }
                ?>
                <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-gear"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="asistencias.php?id=<?php echo $row['id']; ?>">Asistencia</a>
                        <a class="dropdown-item" href="editarEvento.php?id=<?php echo $row['id']; ?>">Editar <i class="bi bi-pencil"></i></a>
                        <a class="dropdown-item" href="#" onclick="mostrarRecuadroEliminar(<?php echo $row['id'];?>)">Eliminar <i class="bi bi-trash"></i></a>
                    </div>
                </div>
                </td>
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
    <div id="overlay" class="no-mostrar">
        <form action="eliminarEvento.php" method="post" id="confirm-box" class="no-mostrar">
            <p>¿Seguro desea eliminar este evento?</p>
            <input id="id-evento" name="id-evento" value="" type="hidden">
            <button class="btn-general mt-1" type="button" onclick="cancelar()">Cancelar</button>
            <button class="btn-general mt-1" type="submit">Confirmar</button>
        </form>
    </div>
</section>
<script src="js\eliminarEvento.js"></script>
<?php include('templates/footer.php')?>