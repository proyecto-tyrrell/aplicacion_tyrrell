<?php

require("ConexionDB.php");

// Conectarse a la base de datos (suponiendo que tengas la función connect() definida)
$conn = connect();

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

//obtener ususario id
$id = $_SESSION['id'];

// obtener notificacion de evento
$sqlNotifiacion= "SELECT COUNT(*) AS cantidad FROM notificaciones WHERE usuario_id = '".$id."' AND visto = false";
$notificacion = mysqli_fetch_assoc(mysqli_query($conn, $sqlNotifiacion));

//mostrar animacion de notificacion
$animacion = "false";

include('templates/head.php')
?>
<?php include('templates/header.php');

if ($notificacion['cantidad'] > 0){ 
    $animacion = "true";?>
    <div class="alert alert-info text-center">Tienes un nuevo evento</div>
<?php } ?>

<p id="animacion" class="no-mostrar"><?php echo $animacion;?></p>

<section class="pt-md-4">
<div class="container">
    <div class="container-botones mt-md-5 mt-2">
        <a href="misEventos.php"><button class="btn-principal" id="misEventos"><i class="bi bi-calendar2-event"></i><br>Mis eventos</button></a>
        <a href="recibos.php" class=""> <button class="btn-principal"><i class="bi bi-receipt-cutoff"></i><br>Recibo de haberes</button> </a>
        <a href="" class=""> <button class="btn-principal"><i class="bi bi-app-indicator"></i><br> Novedades</button></a>
        <a href="solicitud.php" class=""> <button class="btn-principal"><i class="bi bi-menu-up"></i><br> Solicitudes</button></a>
        <a href="vehiculos.php" class=""> <button class="btn-principal"><i class="bi bi-car-front"></i><br> Vehiculos</button></a>
        <a href="proyectos.php" class="tn"> <button class="btn-principal"><i class="bi bi-journal-bookmark-fill"></i><br> Proyectos</button></a>
        <a href="" class=""> <button class="btn-principal"><i class="bi bi-cup-straw"></i><br> Almuerzo</button></a>
        <a href="miUsuario.php" class=""><button class="btn-principal"><i class="bi bi-shield-lock"></i><br> Usuario</button></a>
    <?php if (($_SESSION['rol'] == 'adm') or ($_SESSION['rol'] == 'coord')) {?>
        <a href="empleados.php" class=""> <button class="btn-principal"><i class="bi bi-people-fill"></i><br> Empleados</button></a>
        <a href="eventos.php" class=""> <button class="btn-principal"><i class="bi bi-calendar2-event"></i><br>Eventos</button></a>
        <a href="" class=""> <button class="btn-principal"><i class="bi bi-bar-chart-line"></i><br>Estadísticas</button></a>
        <a href="" class=""><button class="btn-principal"><i class="bi bi-person-workspace"></i><br> RRHH</button></a>
    <?php } ?>
    </div>

</div>
</section>
<script src="js\notificacion.js"></script>
<?php include('templates/footer.php')?>
