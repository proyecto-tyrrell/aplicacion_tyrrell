<?php

session_start();
require 'ConexionDB.php';

if (!empty($_POST['usuario'])){
    $usuario = $_POST['usuario'];
}
if (!empty($_POST['contraseña'])){
    $contrasena = $_POST['contraseña'];
}

$conexionDB = connect();

$sql = "SELECT * FROM usuarios WHERE dni = '".$usuario."' AND pass = '".$contrasena."'";

$resultados = mysqli_fetch_assoc(mysqli_query($conexionDB, $sql));

if ($resultados > 0){
    //iniciar sesion y crear token
    $_SESSION['token'] = uniqid();
    $_SESSION['nombre'] = $resultados['nombreApellido'];
    if ($resultados['categoria'] == 'adm'){
        //redirigir a la pagina de admins
        $_SESSION['rol'] = 'adm';
        header("Location: adm.php");
        exit();
    }
    if ($resultados['categoria'] == 'usuario'){
        //redirigir a la pagina de usuarios
        $_SESSION['rol'] = 'usr';
        header("Location: usuario.php");
        exit();
    }
}else{
    $_SESSION['incorrecto'] = true;
    header("Location: index.php");
}

?>