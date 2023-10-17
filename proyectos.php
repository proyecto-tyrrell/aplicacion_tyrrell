<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Proyectos",
        "url" => "proyectos.php"
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

//consulta a la base de datos
$sql = "SELECT * FROM proyectos order by codigo";

//conectarse a la base de datos
$conn = connect();

$result = mysqli_query($conn, $sql);

if(isset($_POST['desactivar'])){
    $desactivar = "UPDATE proyectos set activo = false WHERE id = '".$_POST['desactivar']."'";
    mysqli_query($conn, $desactivar);
    header('Location: proyectos.php');
    exit;
}


if(isset($_POST['activar'])){
    $desactivar = "UPDATE proyectos set activo = true WHERE id = '".$_POST['activar']."'";
    mysqli_query($conn, $desactivar);
    header('Location: proyectos.php');
    exit;
}

include('templates/head.php')
?>

<?php include('templates/header.php')?>
<?php include('templates/nav.php')?>

<section class=" pt-5">
    <div class="container">
        <div class="text-end">
            <?php
    if ($_SESSION['rol'] == 'adm' || $_SESSION['rol'] == 'coord'){
?>
            <a href="agregarProyecto.php" class="btn-general">
                <i class="bi bi-plus-circle-fill fs-7 me-1"></i> Nuevo proyecto
            </a>
            <?php
    }
?>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td> <?php echo $row['codigo'];?> </td>
                <td> <?php echo $row['nombre'];?></td>
                <td> <?php if ($row['activo']) { ?>
                    <td>Activo</td>
                    <?php if (($_SESSION['rol'] == 'adm') or ($_SESSION['rol'] == 'coord')) { ?>
                        <td><form method="post">
                            <button name="desactivar" class="btn-general" type="submit" value="<?php echo $row['id']; ?>">Presione para desactivar</button>
                        </form></td>
                    <?php 
                    }
                } else { ?>
                    <td>Inactivo</td>
                    <?php if (($_SESSION['rol'] == 'adm') or ($_SESSION['rol'] == 'coord')) { ?>
                        <td><form method="post">
                            <button name="activar" class="btn-general" type="submit" value="<?php echo $row['id']; ?>">Presione para activar</button>
                        </form></td>
                    <?php 
                    }
                }    
                ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</section>
<?php include('templates/footer.php')?>
