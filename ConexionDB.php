<?php
    function connect() {
        $servername = "45.151.120.12";
        $username = "u602072991_root";
        $password = "Br#1+6h:7Me";
        $dbname = "u602072991_Asistencia";

        //conectarse a la base de datos
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        //mostrar codigo de error
        if (!$conn){
            die("conexion fallida: ".mysqli_connect_error());
        }

        return $conn;
    }
?>