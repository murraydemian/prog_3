<?php 
include_once "./validarSesion.php";
    function CerrarSesion(){
        session_unset();
        session_destroy();
        validarSesion();
    }
    //CerrarSesion();
?>