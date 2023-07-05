<?php
    session_start();

    if (!empty($_SESSION['token'])){
        unset($_SESSION['token']);
    }

include('templates/head.php')?>
<header>
    <div class="container text-center">
    <a href="index.php" ><img src="img\tyrrell.jpeg" alt="logo"></a>
</div>
</header>
<div class="container">
<form action="LogIn.php" method="post" id="login-form" class=" text-center">
    <div>
        <label for="user"><i class="bi bi-person-fill me-5 px-0 mx-0"></i></label>
        <input class="" type="text" id="usuario" name="usuario" placeholder="Usuario" required/>
    </div>
    <div >
        <label for="password"><i class="bi bi-key-fill"></i> </label>
        <input class="" type="password" id="password" name="contraseña" placeholder="Contraseña" required/>
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
    <div class="text-center">
        <button type="submit">ENTRAR</button>
    </div>
</form></div>
<?php include('templates/footer.php')?>
