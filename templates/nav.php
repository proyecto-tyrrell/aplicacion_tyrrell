<?php
$nombreSeccion = isset($_GET['nombre']) ? $_GET['nombre'] : "Nombre de la sección";

// Puedes usar htmlspecialchars para evitar problemas de seguridad al mostrar el nombre en HTML.
$nombreSeccionHTML = htmlspecialchars($nombreSeccion);
?>

<nav id="sidebar">
    <button id="desplegar"> </button>
    <ul>
            <li> <a href="misEventos.php"> <i class="bi bi-calendar2-event"> </i>Mis eventos</button></a></li>
            <li> <a href="recibos.php" class=""> <i class="bi bi-receipt-cutoff"> </i>Recibo de haberes</a></li>
            <li> <a href="novedades.php"> <i class="bi bi-app-indicator"> </i>Novedades</a></li>
            <li> <a href="solicitud.php" class=""> <i class="bi bi-menu-up"> </i>Solicitudes</a></li>
            <li> <a href="vehiculos.php" class=""><i class="bi bi-car-front"> </i>Vehiculos</a></li>
            <li> <a href="proyectos.php" class="tn"> <i class="bi bi-journal-bookmark-fill"> </i>Proyectos</a></li>
            <li> <a href="miUsuario.php" class=""> <i class="bi bi-shield-lock"> </i>Usuario</a></li>

        <?php if (($_SESSION['rol'] == 'adm') or ($_SESSION['rol'] == 'coord')) {?>

            <li> <a href="empleados.php" class=""> <i class="bi bi-people-fill"> </i>Empleados</a></li>
            <li> <a href="eventos.php" class=""> <i class="bi bi-calendar2-event"> </i>Eventos</a></li>

            <?php if ($_SESSION['rol'] == 'adm'){ ?>

                <li> <a href="estadisticas.php" class=""> <i class="bi bi-bar-chart-line"> </i>Estadísticas</a></li>
                <li> <a href="RRHH.php" class=""> <i class="bi bi-person-workspace"> </i>RRHH</a></li>

            <?php } 
        }?>
    </ul>

</nav>

<div class="container">
    <div class="fs-5 nav-int pt-2">
        <div id="breadcrumb">

            <?php foreach ($seccionesVisitadas as $index => $seccion) { ?>
            <?php if ($index === count($seccionesVisitadas) - 1) { ?>
            <?php echo $seccion["nombre"]; ?>
            <?php } else { ?>
            <a href="<?php echo $seccion["url"]; ?>"><?php echo $seccion["nombre"]; ?> »</a>
            <?php } ?>
            <?php } ?>

        </div>
    </div>
</div>