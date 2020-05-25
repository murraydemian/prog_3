<?php
    require "./clases/persona.php";
    require "./clases/empleado.php";
    require "./conexion.php";
    require "./validarSesion.php";
    require "./verificarUsuario.php";
    require_once './administracion.php';
    
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
                $key = IniciarSesion();
                echo('{"key":"' . $key . '"}');
            break;
            case 'append':
                try{
                    $emp = json_decode($_POST['data']);
                    $emp->pathFoto = $emp->dni . '_' . $emp->apellido . '.png';
                    if($foo = DB_Traer($emp->dni) == null){
                        ///Guardo la fotito
                        move_uploaded_file($_FILES["photo"]["tmp_name"], '../fotos/' . $_FILES['photo']['name']);
                        rename('../fotos/' . $_FILES['photo']['name'], '../fotos/' . $emp->pathFoto);
                        ///
                        DB_Agregar($emp, 'empleados', true) ? 
                            $r = '{"todoOk":"1"}' :
                            $r = '{"todoOk":"0","error":"Error en carga"}' ;
                    }else{
                        $r = '{"todoOk":"0","error":"Empleado repetido"}';                        
                    }
                    echo $r;
                }catch(Exception $e){
                    echo('{"error":"error"}');
                }
                break;
            default:
                echo('{"error":"accion invalida"}');
                echo('{"action":"' . $_POST['action']. '"}');
            break;
            
        }
    }else{
        echo('{"error":"peticion invalida"}');
    }
?>