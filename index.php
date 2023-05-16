<?php
    session_start();

    if (!empty($_SESSION['token'])){
        unset($_SESSION['token']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyrrell - iniciar sesion</title>
    <link rel="icon" href="\imagenes\tyrrell.ico" type="image/x-icon">
    <link rel="stylesheet" href="estilos\style.css">
</head>
<body>
<header>
    <a href="index.php" id="logo"><img src="imagenes\tyrrell.jpeg" alt="logo"></a>
</header>
<form action="LogIn.php" method="post" id="login-form">
    <div>
        <label for="user">Usuario:</label>
        <input type="text" id="usuario" name="usuario" placeholder="Usuario" required/>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required/>
    </div>
    <div>
        <?php
            if (!empty($_SESSION['incorrecto'])){
        ?>
                <p id="error">Usuario o contraseña incorrectos</p>
        <?php
                unset($_SESSION['incorrecto']);
            }
        ?>
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>
</body>
</html>