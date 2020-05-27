<?php
    require_once './conexion.php';
    require_once "../vendor/autoload.php";
    //pdfPrint();
    function pdfPrint(){
        /*///
        $f = fopen('./dumps/cookies.txt', 'a');
        fwrite($f, $_COOKIE['usrkey'] . '  [' . date('c') . "]\n");
        fclose($f);
        ///*/
        $innerHtml = 
                '<h4>Lista de empleados</h4>'.
                '<table width="100%" style="border:1px solid black;padding: 10px;">'.
                '<tr>'.                
                '<td>Nombre</td>'.
                '<td>Apellido</td>'.
                '<td>DNI</td>'.
                '<td>Sexo</td>'.
                '<td>Legajo</td>'.
                '<td>Sueldo</td>'.
                '<td>Turno</td>'.
                '<td>Foto</td>'.
                "</tr>";
        $innerHtml .= EmpleadosToHTML();
        $innerHtml .= '</table>';
        $pass = str_replace('"', '',$_COOKIE['usrkey']);
        if($pass == '0'){$pass = '6s4gf65s7gt6sd26g4fs';}
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
            'pagenumPrefix' => 'Página nro. ',
            'pagenumSuffix' => ' - ',
            'nbpgPrefix' => ' de ',
            'nbpgSuffix' => ' páginas']);
        $mpdf->SetHeader('| Suarez Murray, Demian Jose |  {PAGENO}{nbpg}');
        $mpdf->setFooter('| https://tpprog.herokuapp.com | {PAGENO}');
        $mpdf->WriteHTML($innerHtml);
        $mpdf->SetProtection(array(), $pass, $pass);
        $mpdf->Output('lista_empleados.pdf', 'F');
    }
    function EmpleadosToHTML(){
        $html = "";
        $arrayEmp = DB_TraerTodos('empleados');
        $count = 0;
        $tr ='';
        if($arrayEmp != null){
            foreach($arrayEmp as $emp){
                $count % 2 == 0 ? $tr = '<tr style="background-color:lightgray">' : $tr = '<tr>';
                $html .= $tr .
               '<td aling="center">'.$emp->GetNombre().'</td>
                <td aling=center>'.$emp->GetApellido().'</td>
                <td aling=center>'.$emp->GetDni().'</td>
                <td aling=center>'.$emp->GetSexo().'</td>
                <td aling=center>'.$emp->GetLegajo().'</td>
                <td aling=center>'.$emp->GetSueldo().'</td>
                <td aling=center>'.$emp->GetTurno().'</td>
                <td aling=center><img src="https://tpprog.herokuapp.com/TP/fotos/'.$emp->GetPathFoto().'" width="100px" height="100px"></td>
                </tr>';  
                $count ++;
            }            
        }
        return $html;
    }
?>