<?php 
    require_once '../paths.php';
    /**
     * Recibe por POST el Apellido y DNI de un empleado y checkea el archivo
     * ../archivos/empledaos.txt para verificar si los datos son los de un 
     * empleado ingresado.
     * Si el empleado no existe muestra un mensaje de error y habilita un link para volver 
     * al login.html.
     * Si el empleado existe redirecciona a mostrar.php
     */
    function VerificarUsuario(){
        if(isset($_POST["txtApellido"]) && isset($_POST["txtDni"])){
            $file = fopen("../archivos/empleados.txt", "r");
            $text = "";
            while(!feof($file)){
                $text = explode("-", trim(fgets($file)));                
                if(count($text) >= 7 && $text[0] == $_POST["txtApellido"] && $text[2] == $_POST["txtDni"]){                    
                    session_start();
                    $_SESSION["DNIEmpleado"] = $_POST["txtDni"];                    
                    header("location: ./mostrar.php");
                    exit();
                }                
            }
            echo('<h4>No existe empleados con datos indicados.</h4><br><a href="./login.html">Volver al login</a>');            
        }
    }
    VerificarUsuario();
?>