<?php 
    include_once '../paths.php';

    function Borrar(){
        if(isset($_GET["legajo"])){ 
            $fab = new Fabrica("foo", 1000000);
            $fab->TraerDeArchivo("../archivos/empleados.txt");
            $emp = $fab->TrearPorLegajo($_GET['legajo']);            
            if($fab->EliminarEmpleadoPorLegajo($_GET['legajo']) && 
                    unlink("../" . $emp->GetPathFoto())){
                $fab->GuardarEnArchivo("../archivos/empleados.txt");            
                echo("Se elimino el empleado.<br>");            
            }else{
                echo("No se pudo eliminar al empleado.<br>");
            }
        }
        echo('<BR><A href="./mostrar.php">Mostrar empleados</A>');
        echo('<BR><a href="../index.php">Volver a pantalla de carga</a>');
    }
    Borrar();
?>