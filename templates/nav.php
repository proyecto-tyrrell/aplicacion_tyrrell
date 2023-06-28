<?php
$nombreSeccion = isset($_GET['nombre']) ? $_GET['nombre'] : "Nombre de la sección";

// Puedes usar htmlspecialchars para evitar problemas de seguridad al mostrar el nombre en HTML.
$nombreSeccionHTML = htmlspecialchars($nombreSeccion);
?>

<nav id="sidebar">
    <button id="desplegar"> </button>
    <ul>
        <li> <a href="recibos.php" class=""> <i class="bi bi-receipt-cutoff me-2"> </i>Recibo de haberes </a></li>
        <li> <a href="" class=""> <i class="bi bi-app-indicator me-2"></i> Novedades </a></li>
        <li> <a href="solicitud.php" class=""> <i class="bi bi-menu-up me-2"></i> Solicitudes </a></li>
        <li> <a href="eventos.php" class=""> <i class="bi bi-calendar2-event me-2"></i> Eventos </a></li>
        <li> <a href="vehiculos.php" class=""> <i class="bi bi-car-front me-2"></i> Vehiculos </a></li>
        <li> <a href="empleados.php" class=""> <i class="bi bi-people-fill me-2"></i> Empleados </a></li>
        <li> <a href="proyectos.php" class="tn"> <i class="bi bi-journal-bookmark-fill me-2"></i> Proyectos </a></li>
        <li> <a href="" class=""> <i class="bi bi-person-workspace me-2"></i> RRHH </a> </li>
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