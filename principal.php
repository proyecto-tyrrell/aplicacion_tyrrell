<?php

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
include('templates/head.php')
?>
<?php include('templates/header.php')?>


<section class="pt-md-4">
<div class="container">
    <div class="container-botones mt-md-5 mt-2">
        <a href="recibos.php" class=""> <button class="btn-principal"><i class="bi bi-receipt-cutoff"> <br></i>Recibo de haberes</button> </a>
        <a href="" class=""> <button class="btn-principal"><i class="bi bi-app-indicator"></i> <br> Novedades</button></a>
        <a href="solicitud.php" class=""> <button class="btn-principal"><i class="bi bi-menu-up"></i> <br> Solicitudes</button></a>
        <a href="eventos.php" class=""> <button class="btn-principal"><i class="bi bi-calendar2-event"></i>  <br>  Eventos</button></a>
        <a href="vehiculos.php" class=""> <button class="btn-principal"><i class="bi bi-car-front"></i>  <br> Vehiculos</button></a>
        <a href="empleados.php" class=""> <button class="btn-principal"><i class="bi bi-people-fill"></i> <br> Empleados</button></a>
        <a href="proyectos.php" class="tn"> <button class="btn-principal"><i class="bi bi-journal-bookmark-fill"></i> <br> Proyectos</button></a>
        <a href="" class=""><button class="btn-principal"><i class="bi bi-person-workspace"></i>  <br> RRHH</button></a>
        <a href="miUsuario.php" class=""><button class="btn-principal"><i class="bi bi-shield-lock"></i>  <br> Usuario</button></a>
    </div>

</div>
</section>
<?php include('templates/footer.php')?>
