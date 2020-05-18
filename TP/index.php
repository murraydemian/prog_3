<?php 
    require_once './paths.php';
    include_once './src/validarSesion.php';
    validarSesion();
    if(isset($_POST['hidDNI'])){
        $emp = (Fabrica::TraerDesdeArchivo("./archivos/empleados.txt"))->TraerPorDNI($_POST['hidDNI']);
        $title = "Modificar Empleado";
        $inDNI = ' value="'. $emp->GetDni() .'" readonly';
        $inLegajo = ' value="' . $emp->GetLegajo() . '" readonly';
        $inNombre = ' value="' . $emp->GetNombre() . '"';
        $inApellido = ' value ="' . $emp->GetApellido() . '"';
        $inSueldo = ' value ="' . $emp->GetSueldo() . '"';
        $rdoTurnoM = '';
        $rdoTurnoT = '';
        $rdoTurnoN = '';
        switch($emp->GetSexo()){
            case "M":
                $cbSexoM = ' selected';
                $cbSexoF = '';
                break;
            case "F":
                $cbSexoF = ' selected';
                $cbSexoM = '';
                break;
        }
        $cbSexoD = '';
        switch($emp->GetTurno()){
            case "Mañana":
                $rdoTurnoM = ' checked';
            break;
            case "Tarde":
                $rdoTurnoT = ' checked';
            break;
            case "Noche":
                $rdoTurnoN = ' checked';
            break;
        }
        $hdnModificar = ' value = "T"';
    }else{
        $title = "Alta de Empleado";
        $inDNI = '';
        $inLegajo = '';
        $inNombre = '';
        $inApellido = '';
        $inSueldo = '';
        $cbSexoD = ' selected';
        $cbSexoM = '';
        $cbSexoF = '';
        $rdoTurnoM = ' checked';
        $rdoTurnoT = '';
        $rdoTurnoN = '';
        $hdnModificar = ' value="F"';
    }
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo "HTML5 " . $title ?></title>
        
        <link rel="stylesheet" href="style.css">
        <script src="./javascript/validaciones.js"></script>
    </head>
    <body>           
        </form>
        <form action="./src/administracion.php"method="POST"id="frmEmpleado"enctype="multipart/form-data">
            <input type="hidden" name="hdnModificar" id="hdnModificar" <?PHP echo $hdnModificar?>>
            <h2><?php echo $title ?></h2>
            <a href="./src/cerrarSesion.php"align="right">[Cerrar sesion]</a>
            <table align="center">
                <tbody>
                    <tr>
                        <td colspan="2"><h4>Datos Personales</h4></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td>DNI:</td>
                        <td style="text-align:left;padding-left:15px;">
                        <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" <?php echo $inDNI ?>>
                            <span id="tgDni"style="display:block;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Apellido:</td>
                        <td style="text-align:left;padding-left:15px;">
                            <input type="text" name="txtApellido" id="txtApellido"<?PHP echo $inApellido?>>
                            <span id="tgApellido"style="display:block;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td style="text-align:left;padding-left:15px;">
                            <input type="text" name="txtNombre" id="txtNombre"<?PHP echo $inNombre?>>
                            <span id="tgNombre"style="display:block;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sexo:</td>
                        <td style="text-align:left;padding-left:15px;">
                            <select name="cboSexo" id="cboSexo">                                
                                <option value="---"<?PHP echo $cbSexoD?>>Seleccione</option>
                                <option value="M"<?PHP echo $cbSexoM?>>Masculino</option>
                                <option value="F"<?PHP echo $cbSexoF?>>Femenino</option>                                
                            </select>
                            <span id="tgSexo"style="display:block;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><h4>Datos Laborales</h4></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td>Legajo:</td>
                        <td style="text-align:left;padding-left:15px;">
                            <input type="number" name="txtLegajo" id="txtLegajo" min="100" max="500" required <?php echo $inLegajo ?>>
                            <span id="tgLegajo"style="display:block;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sueldo:</td>
                        <td style="text-align:left;padding-left:15px;">
                            <input type="number" name="txtSueldo" id="txtSueldo" min="8000" step="500" <?PHP echo $inSueldo?>>
                            <span id="tgSueldo"style="display:block;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Turno:</td>
                    </tr>
                    <tr>
                        <td></td>				
                        <td> 
                            <input type="radio" name="rdoTurno" value="Mañana" <?PHP echo $rdoTurnoM?>/>
                            Mañana						
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="radio" name="rdoTurno" value="Tarde" <?PHP echo $rdoTurnoT?>/>
                            Tarde					
                        </td>
                    </tr>
                    <tr>
                        <td></td>		
                        <td>
                            <input type="radio" name="rdoTurno" value="Noche" <?PHP echo $rdoTurnoN?>/>						
                            Noche
                        </td>
                    </tr>
                        <td>Foto:</td>
                        <td>
                            <input type="file"accept="image/png,.jpg,image/gif"id="imgEmp"name="foto">
                            <span id="tgFoto"style="display:block;">*</span>
                        </td>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="reset" value="Limpiar"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="button" onclick="AdministrarValidaciones()" id="btnEnviar" value="Enviar"/>                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>