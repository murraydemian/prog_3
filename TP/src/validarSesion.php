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
            $key = substr($_COOKIE['usrkey'], 1);
            ///
            $f = fopen('./dumps/cookies.txt', 'a');
            fwrite($f, $_COOKIE['usrkey'] . '  [' . date('c') . "]\n");
            fclose($f);
            ///
            return VerificarExistencia($key);
        }else{
            return false;
        }
    }
    function IniciarSesion(){
        $data = $_POST['data'];
        //var_dump($data['dni']);
        $e = DB_Traer($data['dni']);        
        if($e != null && $e->GetApellido() == $data['apellido']){
            return $e->GetDni();
        }else{
            return "0";
        }
    }
?>