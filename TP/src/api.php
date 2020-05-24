<?php
    require "./clases/persona.php";
    require "./clases/empleado.php";
    require "./conexion.php";
    require "./validarSesion.php";
    require "./verificarUsuario.php";
    require_once './administracion.php';
    
    //$pet = json_decode($_POST['data']);
    //echo($pet['action']);

    //echo(json_encode($_POST['data']));
    if(isset($_POST['action'])){
        //$pet = json_encode()
        $action = $_POST['action'];
        switch($action){
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
            case('append'):
                //echo('{"hola":"'. $_POST['action'] .'"}');
                try{
                    $emp = json_decode($_POST['data']);
                    $emp->pathFoto = $emp->dni . '_' . $emp->apellido . '.png';
                    move_uploaded_file($_FILES["photo"]["tmp_name"], '../fotos/' . $_FILES['photo']['name']);
                    rename('../fotos/' . $_FILES['photo']['name'], '../fotos/' . $emp->pathFoto);
                    DB_Agregar($emp, 'empleados', true); 
                    echo('{"todoOk":"1"}');
                }catch(Exception $e){
                    echo('{"error":"'. $e->GetMessage() .'"}');
                }
            break;
            default:
                $action = $_POST['action'];
                $emp = json_decode($_POST['data']);
                $emp->pathFoto = $emp->dni . '_' . $emp->apellido . '.png';
                var_dump($emp);
                $res = ob_get_clean();
                $f = fopen('./dump.html', 'w');
                fwrite($f, $res);
                fclose($f);
                move_uploaded_file($_FILES["photo"]["tmp_name"], '../fotos/' . $_FILES['photo']['name']);
                rename('../fotos/' . $_FILES['photo']['name'], '../fotos/' . $emp->pathFoto);
                //$j = json_decode($_POST['data']);
                //echo(json_encode($j));
                //echo('{"action":"'. $action .'"}');
                echo('{"action":"'. $emp->pathFoto .'"}');
            break;
        }
    }
?>