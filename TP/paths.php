<?php
    if(isset($_SERVER['REQUEST_URI'])){
        if($_SERVER['REQUEST_URI'] == '/prog_3/TP/src/administracion.php' ||
            $_SERVER['REQUEST_URI'] == '/prog_3/TP/src/verificarUsuario.php' ||
            $_SERVER['REQUEST_URI'] == '/prog_3/TP/src/eliminar.php'){
            //require_once "./validarSesion.php";
            require_once "./persona.php";
            require_once './empleado.php';
            require_once "./interfaces.php";
            require_once "./fabrica.php";
        }else if($_SERVER['REQUEST_URI'] == '/prog_3/TP/index.php'){
            //require_once "./src/validarSesion.php";
            require_once "./src/persona.php";
            require_once './src/empleado.php';
            require_once "./src/interfaces.php";
            require_once "./src/fabrica.php";
        }
    }
?>