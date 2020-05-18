<?php
    if(isset($_SERVER['REQUEST_URI'])){
        if($_SERVER['REQUEST_URI'] == '/prog_3/TP/src/administracion.php' ||
            $_SERVER['REQUEST_URI'] == '/prog_3/TP/src/verificarUsuario.php' ||
            $_SERVER['REQUEST_URI'] == '/prog_3/TP/src/eliminar.php'){
            //require_once "./validarSesion.php";
            require_once "./clases/persona.php";
            require_once './clases/empleado.php';
            //require_once "./clases/interfaces.php";
            require_once "./clases/fabrica.php";
        }else if($_SERVER['REQUEST_URI'] == '/prog_3/TP/index.php'){
            //require_once "./src/validarSesion.php";
            require_once "./src/clases/persona.php";
            require_once './src/clases/empleado.php';
            //require_once "./src/clases/interfaces.php";
            require_once "./src/clases/fabrica.php";
        }
    }
?>