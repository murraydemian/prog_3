<?php 
    include_once '../paths.php';
   

    function Administrar(){
        try{

            if(isset($_POST['hdnModificar'])){
                if($_POST['hdnModificar'] == "T"){
                    ModificarEmpleado();
                } else if($_POST['hdnModificar'] == "F"){
                    AgregarEmpleado();
                }                
            }
        }catch(Exception $e){
            echo($e->getMessage());
        }finally{
            echo("<BR><a href=../index.php>Volver a pantalla de carga</a>");
        }
    }
    function VerificarImagen(){
        $ret = false;
        if(isset($_FILES["foto"])){            
            if(!file_exists('./fotos/'.$_FILES["foto"]["name"])&&
                ((int)$_FILES["foto"]["size"]) <= 1048576){                
                $ret = true;
            }else{
                throw new Exception("El archivo ". $_FILES["foto"]["name"] ." ya esxiste o es muy grande.");
            }
        }
        return $ret;
    }
    function GenerarEmpleado(){        
        $emp = new Empleado(
            $_POST["txtNombre"],
            $_POST["txtApellido"],
            $_POST["txtDni"],
            $_POST["cboSexo"],
            $_POST["txtLegajo"],
            $_POST["txtSueldo"],
            $_POST["rdoTurno"]
        );        
        return $emp;
    }
    function GenerarFabrica($cap){
        $fab = new Fabrica("foo" , $cap);
        $fab->TraerDeArchivo("../archivos/empleados.txt");
        return $fab;
    }
    function AgregarEmpleado(){
        $emp = GenerarEmpleado();
        VerificarImagen() ? $_FILES["foto"]["name"] = $emp->GetDni()."_". $emp->GetApellido() :
            $_FILES["foto"]["name"] = null;                
        $fab = GenerarFabrica(1000);
        isset($_FILES["foto"]["name"]) ? $emp->SetPathFoto("fotos/" . $_FILES["foto"]["name"].".png") : 
        $emp->SetPathFoto(null);
        if($emp->GetPathFoto() != null && $fab->AgregarEmpleado($emp)){
            $fab->GuardarEnArchivo("../archivos/empleados.txt");
            move_uploaded_file($_FILES["foto"]["tmp_name"], '../' . $emp->GetPathFoto());
            echo('Se guardo el empleado.<BR><A href="./mostrar.php">Mostrar empleados</A>');
        }else{
            echo('No se pudo guardar el empleado.<BR><A href="./mostrar.php">Mostrar empleados</A>');
        }
    }
    function ModificarEmpleado(){
        $emp = GenerarEmpleado();
        $fab = GenerarFabrica(1000);
        $old = ($fab->TraerPorDNI($emp->GetDni()))->GetPathFoto();
        $new = 'fotos/' . $emp->GetDni() . '_' . $emp->GetApellido() . '.png';
        if(VerificarImagen()){
            rename('../' . $old, '../deleted/' . $old );
            move_uploaded_file($_FILES['foto']['tmp_name'], '../' . $new);
        }else{
            rename('../' . $old, '../' . $new);
        }
        $emp->SetPathFoto($new);
        //eliminar compara por legajo, el cual no pudo ser modificado
        $fab->EliminarEmpleado($emp);
        $fab->AgregarEmpleado($emp);   
        $fab->GuardarEnArchivo('../archivos/empleados.txt');    
    }
            
    Administrar();
?>