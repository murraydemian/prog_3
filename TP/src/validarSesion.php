<?php

    function ValidarSesion(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION["DNIEmpleado"])){
            header("location: http://localhost/prog_3/TP/login.html");
            exit;
        }       
    }
    ValidarSesion();
?>