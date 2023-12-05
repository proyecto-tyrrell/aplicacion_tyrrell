<?php

session_start();
require 'ConexionDB.php';

if (!empty($_POST['usuario'])){
    $usuario = $_POST['usuario'];
}
if (!empty($_POST['contraseña'])){
    $contrasena = $_POST['contraseña'];
}
if (!empty($_POST['vehiculo'])){
    $vehiculo = $_POST['vehiculo'];
}

$conexionDB = connect();

$sql = "SELECT * FROM usuarios WHERE dni = '".$usuario."' AND pass = '".$contrasena."'";

$resultados = mysqli_fetch_assoc(mysqli_query($conexionDB, $sql));

if ($resultados > 0){
    //iniciar sesion y crear token
    $_SESSION['token'] = uniqid();
    $_SESSION['nombre'] = $resultados['nombreApellido'];
    if ($resultados['categoria'] == 'adm'){
        $_SESSION['rol'] = 'adm';
    }
    if ($resultados['categoria'] == 'usuario'){
        $_SESSION['rol'] = 'usr';
    }
    if ($resultados['categoria'] == 'coord'){
        $_SESSION['rol'] = 'coord';
    }
    $_SESSION['id'] = $resultados['id'];
    if (empty($vehiculo)){
        header("Location: principal.php");
    }else{
        header("Location: registrarConduccion.php?vehiculo=".$vehiculo);
    }
    exit();
}else{
    $_SESSION['incorrecto'] = true;
    header("Location: index.php");
    exit();
}

?>