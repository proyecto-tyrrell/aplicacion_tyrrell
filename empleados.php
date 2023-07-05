<?php
// Breadcrumb Nav para Volver a la seccion anterior
$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Empleados",
        "url" => "empleados.php"
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
$sql = "SELECT id, nombreApellido, dni , celular FROM usuarios ORDER BY nombreApellido ASC;";

//seleccionar los id de los usuarios que este cargado en un evento que esta sucediendo ahora (usuarios ocupados)
$sqlEstado = "SELECT usuario_id FROM eventoUsuarios WHERE evento_id IN (
        SELECT id FROM eventos WHERE fecha_inicio <= '".date('Y-m-d H:i:s')."' AND fecha_fin > '".date('Y-m-d H:i:s')."')";

//conectarse a la base de datos
$conn = connect();

$result = mysqli_query($conn, $sql);
$estadoResult = mysqli_query($conn, $sqlEstado);
$estadoRows = array();

while ($estadoRow = mysqli_fetch_assoc($estadoResult)) {
    $estadoRows[] = $estadoRow['usuario_id'];
}

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
            <th scope=" col">Nombre</th>
            <th scope="col">DNI</th>
            <th scope="col">Celular</th>
            <th scope="col">Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['nombreApellido']?></td>
                <td> <?php echo $row['dni'] ?></td>
                <td> <?php echo $row['celular'] ?></td>
                <td class="<?php echo ($ocupado) ? "ocupado" : "disponible"; ?>">
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

                    // Mostrar "Disponible" o "Ocupado" según el valor de $ocupado
                    if ($ocupado) {
                        echo "Ocupado";
                    } else {
                        echo "Disponible";
                    }
                ?>
                </td>
            </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
</section>
<?php include('templates/footer.php')?>