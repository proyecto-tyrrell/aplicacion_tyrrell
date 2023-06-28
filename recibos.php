<?php
// Breadcrumb Nav para Volver a la seccion anterior

$seccionesVisitadas = array(
    array(
        "nombre" => "Inicio",
        "url" => "principal.php"
    ),
    array(
        "nombre" => "Recibos",
        "url" => "recibos.php"
    ),

);
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
<?php include('templates/nav.php')?>
<section class=" pt-5">
    <div class="container ">
        <!-- <iframe
                src="https://na4.documents.adobe.com/public/esignWidget?wid=CBFCIBAA3AAABLblqZhCKdSgwC84pG8aGWi2uSMZBdvdR3RNe33OIwwiFmjJUjFAKIlXdMfxAW9uLVAFuN44*&hosted=false"
                width="100%" height="100%" frameborder="0"
                style="border: 0; overflow: hidden; min-height: 500px; min-width: 600px;"></iframe> -->
            <form class="form" action="<?php // echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class=" d-md-flex col-md-6">
                    <label class="me-3 pt-2" for="mes">Seleccionar Liquidación:</label>
                    <select type="submit" name="lista" id="" class="form-select fs-4 col-md-4 pt-0">
                        <?php // while ($fila = mysqli_fetch_assoc($result)) { ?>
                        <!-- <option value="<?php // echo $fila['nombre']; ?>"><?php // echo $fila['nombre']; ?></option>"; -->
                        <option value="">Enero</option>
                        <option value="">Febrero</option>
                        <option value="">Marzo</option>
                        <option value="">Abril</option>
                        <option value="">Mayo</option>
                        <option value="">Junio</option>
                        <option value="">Julio</option>
                        <option value="">Agosto</option>
                        <option value="">Septiembre</option>
                        <option value="">Octubre</option>
                        <option value="">Noviembre</option>
                        <option value="">Diciembre</option>
                        <?php
                            // } mysqli_free_result($result);
                            // mysqli_close($conn);
                                ?>
                    </select>
                </div>
            </form>
            </div>
    </section>
    <section class=" pt-5">
    <div class="container ">

        <form class="" action="generar_pdf.php" method="post">
            <?php include('templates/reciboform.php')?>
            <button type="submit" class="btn-general mt-5 mx-3">DESCARGAR PDF </button>
        </form>
    </div>
</section>

<?php include('templates/footer.php')?>