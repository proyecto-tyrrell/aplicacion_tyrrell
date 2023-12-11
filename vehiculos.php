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
);

require("ConexionDB.php");

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

//consulta a la base de datos
$sql = "SELECT * FROM vehiculos ORDER BY modelo ASC;";

//seleccionar los id de los vehiculos que este cargado en un evento que esta sucediendo ahora (usuarios ocupados)
$sqlEstado = "SELECT vehiculo_id FROM eventoVehiculos WHERE evento_id IN (SELECT id FROM eventos WHERE fecha_inicio <= '".date('Y-m-d H:i:s')."' AND fecha_fin > '".date('Y-m-d H:i:s')."')";

$result = mysqli_query($conn, $sql);
$estadoResult = mysqli_query($conn, $sqlEstado);
$estadoRows = array();

while ($estadoRow = mysqli_fetch_assoc($estadoResult)) {
    $estadoRows[] = $estadoRow['vehiculo_id'];
}

function obtenerUso($vehiculoId){
    global $conn;

    //consulta SQL para obtener uso por vehiculo por proyecto
    $sqlUso = "SELECT p.nombre as proyecto , count(*) as cantidad FROM vehiculoProyecto vp JOIN proyectos p on p.id = vp.proyecto_id WHERE vehiculo_id = $vehiculoId GROUP BY nombre";

    $result = mysqli_query($conn, $sqlUso);

    if ($result) {
        $uso = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $uso[] = $row;
        }
        return $uso;
    } else {
        return array("Error al obtener uso");
    }
}

function obtenerObservaciones($vehiculoId) {
    global $conn;

    // Consulta SQL para obtener observaciones
    $sqlObservaciones = "SELECT DATE(fecha) as fecha, mensaje FROM mensajeVehiculos WHERE vehiculo_id = $vehiculoId";

    $result = mysqli_query($conn, $sqlObservaciones);
    
    if ($result) {
        $observaciones = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $observaciones[] = $row;
        }
        return $observaciones;
    } else {
        return array("Error al obtener observaciones");
    }
}

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
        <div class=" text-center">
            <a href="problemaVehiculo.php">
                <button class="btn-general rounded"><i class="bi bi-exclamation-lg"></i> Reportar problema </button>
            </a>
        </div>
    <div class="container">

        <!-- Modal observaciones -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Observaciones</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal uso -->
        <div class="modal fade" id="modalUso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalUsoLabel">Uso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <table id="miTabla" class="table table-striped">
            <thead>
            <tr>
                <th scope="col" class="text-center">Modelo</th>
                <th scope="col"  class="text-center">Patente</th>
                <th scope="col"  class="text-center">Kilometraje</th>
                <th scope="col"  class="text-center">Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td  class="text-center"><?php echo $row['modelo']?></td>
                <td  class="text-center"> <?php echo $row['patente'] ?></td>
                <td  class="text-center"> <?php echo $row['kilometraje'] ?></td>

                <?php
                    $id = $row['id']; // Obtener el ID de la fila actual
                    $ocupado = false; // Variable para almacenar si el ID está disponible
                    
                     // Verificar si el ID está en el resultado de la consulta $estado
                    foreach ($estadoRows as $estadoRow) {
                        if ($id == $estadoRow) {
                            $ocupado = true;
                            break;
                        }
                    }
                ?>
                
                <td class="<?php echo ($ocupado) ? "ocupado" : "disponible"; ?>">
                    <p class=p-3 disponible>
                <?php
                    // Mostrar "Disponible" o "Ocupado" según el valor de $ocupado
                    if ($ocupado) {
                        echo "Ocupado";
                    } else {
                        echo "Disponible";
                    }
                ?>
                </p>
                </td>

                <td class="text-center">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-gear"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#myModal"  data-observaciones="<?php
                            $observaciones = obtenerObservaciones($row['id']);
                            $observacionesJson = json_encode($observaciones);
                            echo htmlspecialchars($observacionesJson);
                        ?>"><i class="bi bi-info-circle"></i> Observaciones</button>
                        <button class="2dropdown-item" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#modalUso"         
                            data-uso="<?php 
                            $uso = obtenerUso($row['id']);
                            $usoJson = json_encode($uso);
                            echo htmlspecialchars($usoJson);?>"
                        ><i class="bi bi-car-front-fill"></i> Uso</button>
                    </div>
                </div>
                </td>
                
            </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
</section>
<script src="js\usoVehiculos.js"></script>
<script src="js\observacionesVehiculo.js"></script>
<?php include('templates/footer.php')?>