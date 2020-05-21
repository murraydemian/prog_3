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
        $e = DB_Traer($_POST['data']['dni']);
        if($e != null){
            return $e->GetDni();
        }else{
            return "0";
        }
    }
?>