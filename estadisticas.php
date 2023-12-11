<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Estadisticas",
        "url" => "estadisticas.php"
    ),
   
);

require "ConexionDB.php";


//conectarse a la base de datos
$conn = connect();


//obtener los valores de inicio de sesion
session_start();

//verificar si el token de inicio de sesion esta presente en la variable $_session
if (empty($_SESSION['token'])) {
    //si no esta el token de inicio de sesion redirigir al index
    header('Location: index.php');
    exit;
}else{
    if ($_SESSION['rol'] !== "adm"){
        header('Location: principal.php');
        exit;
    } 
}

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];


$sqlObtenerUsuarios = "SELECT * from usuarios order by nombreApellido";
$usuarios = mysqli_query($conn, $sqlObtenerUsuarios);

// Obtener el nombre de usuario
$nombre_usuario = $_SESSION['nombre'];

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container mb-3">
        <form class="d-inline "  method="post" style="vertical-align: center" action="">
            <label class=" d-inline" for="mes">Mes:</label>
            <select name="mes" id="mes">
                <option value="1" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 1){ echo "selected";}?>>Enero</option>
                <option value="2" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 2){ echo "selected";}?>>Febrero</option>
                <option value="3" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 3){ echo "selected";}?>>Marzo</option>
                <option value="4" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 4){ echo "selected";}?>>Abril</option>
                <option value="5" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 5){ echo "selected";}?>>Mayo</option>
                <option value="6" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 6){ echo "selected";}?>>Junio</option>
                <option value="7" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 7){ echo "selected";}?>>Julio</option>
                <option value="8" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 8){ echo "selected";}?>>Agosto</option>
                <option value="9" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 9){ echo "selected";}?>>Septiembre</option>
                <option value="10" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 10){ echo "selected";}?>>Octubre</option>
                <option value="11" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 11){ echo "selected";}?>>Noviembre</option>
                <option value="12" <?php if(!empty($_POST['mes']) && $_POST['mes'] == 12){ echo "selected";}?>>Diciembre</option>
            </select>
            <label class=" d-inline" for="year-select">Año:</label>
            <select id="year-select" name="year" <?php if(!empty($_POST['year'])){ echo $_POST['year'];}?>></select>
            <script>
                let yearSelect = document.getElementById('year-select');
                let currentYear = new Date().getFullYear();

                for (let year = currentYear; year >= 2022; year--) {
                    let option = document.createElement('option');
                    option.value = year;
                    option.text = year;
                    yearSelect.appendChild(option);
                }

                yearSelect.value = currentYear;


            <?php if (empty($_POST['mes'])) { ?>

                let monthSelect = document.getElementById('mes');
                let currentMonth = new Date().getMonth() + 1; // El método getMonth() devuelve valores de 0 a 11, por eso se suma 1

                monthSelect.value = currentMonth;
            <?php } ?>
            </script>
            <button type="submit" class="btn-general ms-2 px-3  d-inline" name="filtrar">
                <i class="bi bi-funnel fs-6 me-1"></i> Filtrar
            </button>
        </form>
    </div>
    <?php if(isset($_POST['filtrar'])) { ?>
        <div class="container">
            <table class="table table-striped">
                <thead><tr>
                    <th scope="col">Nombre</td>
                    <th scope="col">Cantidad de convocatorias</th>
                    <th scope="col">Asistencias</th>
                    <th scope="col">Inasistencias</th>
                    <th scope="col">Horas trabajadas</th>
                    <th scope="col">Proyecto</th>
                </tr><thead>
                <?php while ($usuario = mysqli_fetch_assoc($usuarios)){
                    $sqlProyectos = "select proyecto_id from eventos join eventoUsuarios eu on eventos.id = eu.evento_id where eu.usuario_id = '".$usuario['id']."' 
                    and month(fecha_inicio) = '".$_POST['mes']."' and year(fecha_inicio) = '".$_POST['year']."' group by eventos.proyecto_id";

                    $proyectos = mysqli_query($conn, $sqlProyectos);
                    while ($proyecto = mysqli_fetch_assoc($proyectos)){
                ?>
                <tr>
                    <td><?php echo $usuario['nombreApellido']; ?></td>
                    <?php

                        $sqlCantidadHoras= "SELECT ingreso, salida FROM eventoUsuarios WHERE usuario_id = '".$usuario['id']."' and evento_id IN 
                        (SELECT id from eventos WHERE month(fecha_inicio) = '".$_POST['mes']."' and year(fecha_inicio) = '".$_POST['year']."' and proyecto_id = '".$proyecto['proyecto_id']."')";
                        $totalHoras = mysqli_query($conn, $sqlCantidadHoras);
                        $total = 0; //total horas
                        $cantidadEventos = 0;
                        $asistencias = 0; //cantidad de asistencias
                        $inasistencias = 0; //cantidad inasistencias
                        while ($horas = mysqli_fetch_assoc($totalHoras)){
                            $suma = 0;
                            $cantidadEventos ++;
                            if (($horas['ingreso'] != null) && ($horas['salida'] != null)){
                                $ingreso = new DateTime($horas['ingreso']);
                                $salida = new DateTime($horas['salida']);
                                $interval = $ingreso->diff($salida);
                                $suma = $interval->h;
                                $total += $suma;
                                $asistencias ++; //cantidad de asistencias + 1
                            }else{
                                $inasistencias ++; // inasistencias + 1
                            }
                        }
                    ?>
                    <td><?php echo $cantidadEventos;?></td>
                    <td><?php echo $asistencias;?></td>
                    <td><?php echo $inasistencias;?></td>
                    <td><?php echo $total;?>hs</td>
                    <td><?php
                        $sqlNombreProyecto = "SELECT nombre, codigo FROM proyectos where id = " .$proyecto['proyecto_id'];
                        $nombreProyecto = mysqli_fetch_assoc(mysqli_query($conn, $sqlNombreProyecto));
                        echo $nombreProyecto['nombre'] . ", " . $nombreProyecto['codigo'];
                    ?>
                    </td>
                </tr>
                <?php } 
                }
                ?>
            </table>
        </div>
    <?php } ?>
</section>
<?php include('templates/footer.php')?>
