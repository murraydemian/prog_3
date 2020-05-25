<?php
    require "./clases/persona.php";
    require "./clases/empleado.php";
    require "./conexion.php";
    require "./validarSesion.php";
    require "./verificarUsuario.php";
    require_once './administracion.php';
    
    if(isset($_POST['action'])){
        if($_POST['action'] != 'login'){
            if(!ValidarSesionCookie()){
                $_POST['action'] = 'notlogged';
            }
        }
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
            case 'mostrar':
                try{
                    $emp = json_decode($_POST['data']);
                    $obj = DB_Traer($emp->dni);
                    if($obj != null){                        
                        $r = '{"todoOk":"1","datos":' . $obj->ToJSON() . '}';
                    }else{
                        $r = '{"todoOk":"0","error":"Empleado inexistente"}';
                    }
                    echo $r;
                }catch( Exception $e){
                    echo('{"error":"error"}');
                }
            break;
            case 'mostrartodos':
                $lista = DB_TraerTodos();
                $count = 0;
                if($lista != null){
                    $r = '{"todoOK":"1","datos":{';
                    foreach($lista as $emp){
                        $r .= '"'.$count.'":'.$emp->ToJSON().',';
                        $count ++;
                    }
                    $r = substr($r,0,-1);
                    $r .= '}}';
                    echo $r;
                }
            break;
            case 'modificarsfoto':
                $new = json_decode($_POST['data']);
                $new->pathFoto = $new->dni . '_' . $new->apellido . '.png';
                $old = DB_Traer($new->dni);
                if(VerificarExistencia($new->dni)){                    
                    if(DB_Modificar($new,'empleados')){
                        rename('../fotos/'.$old->GetPathFoto(), '../fotos/' . $new->pathFoto);
                        $r = '{"todoOk":"1","accion":"Se modifico el empleado '.$new->dni.'"}';
                    }else{
                        $r = '{"todoOk":"0","error":"No se pudo modificar la tabla"}';
                    }
                }else{
                    $r = '{"todoOk":"0","error":"Empleado inexistente"}';
                }
                echo $r;
            break;
            case 'modificarcfoto':
                $new = json_decode($_POST['data']);
                $new->pathFoto = $new->dni . '_' . $new->apellido . '.png';
                $old = DB_Traer($new->dni);
                if($old != null){     
                    rename('../fotos/'.$old->GetPathFoto(), '../fotos/borrados/'.date('Ymd-His').$old->GetPathFoto());
                    ///Guardo la fotito
                    move_uploaded_file($_FILES["photo"]["tmp_name"], '../fotos/' . $_FILES['photo']['name']);
                    rename('../fotos/' . $_FILES['photo']['name'], '../fotos/' . $new->pathFoto);
                    ///
                    if(DB_Modificar($new,'empleados')){
                        $r = '{"todoOk":"1","accion":"Se modifico el empleado '.$new->dni.'"}';
                    }else{
                        $r = '{"todoOk":"0","error":"No se pudo modificar la tabla"}';
                    }
                }else{
                    $r = '{"todoOk":"0","error":"Empleado inexistente"}';
                }
                echo $r;
            break;
            case 'eliminar':
                $data = json_decode($_POST['data']);
                $out = DB_Traer($data->dni);
                if($out != null){
                    $in = json_decode($out->ToJSON());
                    DB_Agregar($in, 'borrados');
                    $t = DB_Eliminar($out->GetId(), 'empleados');
                    $t ? $r = '{"todoOk":"1","accion":"Se elimino el empleado '.$data->dni.'"}' :
                        $r = '{"todoOk":"0","error":"No se pudo modificar la tabla"}';
                    echo $r;
                }else{
                    echo('{"error":"Empleado no existe"}');
                }
            break;
            case 'notlogged':
                echo('{"error":"sesion no iniciada"}');
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