<?php

    function ValidarSesion(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION["DNIEmpleado"])){
            header("location: ./login.html");
            exit;
        }       
    }
    ValidarSesion();
?>