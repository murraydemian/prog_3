<?php
    require "./clases/persona.php";
    require "./clases/empleado.php";
    require "./conexion.php";
    require "./validarSesion.php";

    if(isset($_POST['action'])){
        
        switch($_POST['action']){
            case 'check':
                if(ValidarSesionCookie()){
                    echo "1";
                }else{
                    echo "0";
                }
            break;
            case 'login':
                return IniciarSesion();
            break;
        }
    }
?>