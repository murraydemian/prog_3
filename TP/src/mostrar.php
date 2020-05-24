<?php    
    include_once "./validarSesion.php";

    function MostrarLista(){
        //verifico si hay una sesion iniciada   
        ValidarSesion();  
        //inicializo variables   
        $str = "";
        $empStr = "";
        $file = fopen("../archivos/empleados.txt", "r");
        //levanto los datos del archivo
        while(!feof($file)){
            $str = $str . fgets($file) . "|";
        }
        fclose($file);
        //sobran unos caracteres al principio, asi que los ignoro
        $str = substr($str, 3, strlen($str)-4);
        $str = explode("|", $str);
        //preparo el html
        $webPage = 
        '<html>'. "\n" .
        '<head>' . "\n" .
        '   <script src="../javascript/validaciones.js"></script>' . "\n" .
        '   <title>Lista de Empleados</title>' . "\n" .
        '</head>' . "\n" .
        '<body>'. "\n" . 
        '   <h2>Lista de Empleados</h2>'. "\n" .
        '   <a href="./cerrarSesion.php">[Cerrar Sesion]</a>' . "\n" .
        '   <form action="../index.php" id="frmModificar" method="POST">' . "\n" .
        '   <input type="hidden" id="hidDNI" name="hidDNI">' . "\n" .
        '   </form>' . "\n" .       
        '   <table aling="center">'. "\n" .
        '       <tbody>'. "\n" .
        '           <tr>'. "\n" .
        '               <td colspan="4">'. "\n" .
        '                   <h4>Info</h4>' . "\n" . 
        '               </td>'. "\n" . 
        '           </tr>'. "\n" .
        '           <tr>'. "\n" . 
        '               <td colspan="4">'. "\n" .
        '                   <hr>'. "\n" .
        '               </td>' . "\n" . 
        '           </tr>'. "\n";        
        for($i = 0; $i < count($str); $i++){
            $empStr = explode("-", $str[$i]); //format: "apellido-nombre-dni-sexo-legajo-sueldo-turno"
            $webPage .= 
        '           <tr>' . "\n" . 
        '               <td>' . $empStr[2] . " - " . $empStr[1] . " - " . $empStr[0] . " - " . $empStr[3] .
                            " - " . $empStr[4] . " - " . $empStr[5] . " - " . $empStr[6]. 
        '               </td>' . "\n" . 
        '               <td>' . "\n" .
        '                   <img src="../'. trim($empStr[7]) . '" alt="" height="100" width="100">' . "\n" .
        '               </td>' . "\n" .
        '               <td>' . "\n" .
        '                   <a href="./eliminar.php?legajo='. $empStr[4] . '"> [Eliminar]</a>' . "\n" .
        '               </td>'. "\n" .
        '               <td>' . "\n" .
        '                   <input type="button" onclick="AdministrarModificar(' . "'" . $empStr[2] . "'" . ')" value="modificar" name="btnMod"/>' . "\n" .
        '               </td>' . "\n" .
        '           </tr>' . "\n";
        }
        $webPage .= 
        '           <tr>'. "\n" .
        '               <td colspan="4">'. "\n" .
        '                   <hr>'. "\n" .
        '               </td>'. "\n" .
        '           </tr>'. "\n" . 
        '       </tbody>'. "\n" .
        '   </table>' . "\n" . 
        '   <BR>' . "\n" . 
        '   <a href="../index.php">Volver a pantalla de carga</a>'. "\n" .
        '</body>'. "\n" .
        '</html>';
        echo $webPage;
    }


    //MostrarLista();
?>