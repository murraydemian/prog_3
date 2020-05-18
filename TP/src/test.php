<?php
    namespace TP_Parte_1;

    require_once "./empleado.php";
    require_once "./fabrica.php";

    echo("Testeamos el Empleado->Tostring<br>");
    $emp1 = new Empleado("Lucia", "🐕🐕", 12345678, 'F', "123", 5000, "Mañana");
    $emp2 = new Empleado("Pedro", "Peralta", 10100100, 'M', "456", 5000, "Mañana");
    $emp3 = new Empleado("Cristobal", "Colon", 10200200, 'M', "789", 5000, "Tarde");
    $emp4 = new Empleado("Adolfo", "Nilopienses", 10300300, 'M', "945", 5000, "Noche");
    echo($emp1->ToString());

    echo("<br><br>Testeamos el Empleado->Hablar");
    $idiomas = array("Español", "Ingles", "Portugues");
    echo("<br>" . $emp1->Hablar($idiomas));

    $fab = new Fabrica("26-12345678-6");
    $fab->AgregarEmpleado($emp1);
    echo("<BR><BR><BR>" . $fab->ToString());
    $fab->AgregarEmpleado($emp2);
    $fab->AgregarEmpleado($emp3);
    $fab->AgregarEmpleado($emp4);
    echo("<BR><BR><BR>" . $fab->ToString());    
    echo("<BR><BR>" . $fab->CalcularSueldos());
    

?>