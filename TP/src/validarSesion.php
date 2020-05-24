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
    function ValidarSesionCookie(){
        if(isset($_COOKIE['usrkey'])){
            return VerificarExistencia($_COOKIE['usrkey']);
        }else{
            return false;
        }
    }
    function IniciarSesion(){
        $data = json_decode($_POST['data']);
        $e = DB_Traer($data->dni);        
        if($e != null && $e->GetApellido() == $data->apellido){
            return $e->GetDni();
        }else{
            return "0";
        }
    }
?>