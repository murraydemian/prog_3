<?PHP
    include_once "./exception/exceptions.php";
    include_once './clases/persona.php';
    include_once './clases/empleado.php';


    //DB_Traer(39514859, 'empleados');
    /**Retorna la cadena de coneccion a la base de datos */
    function ConectionString(){
        return 'mysql:host=localhost;dbname=tp_prog';
    }
    /**Verifica si el empleado ya esta ingresado, si los datos no estan duplicados, lo agrega a la DB */
    function DB_Agregar($emp, $tabla = "empleados", $verificar = true){
        /*
        ///
                var_dump($emp);
                $res = ob_get_clean();
                $f = fopen('./dump.html', 'w');
                fwrite($f, $res);
                fclose($f);
        ///
        if(VerificarExistencia($emp->dni, 'empleados') && $verificar){
            throw new EmpleadoRepetidoException();
        }else{
            $pdo = new PDO(ConectionString(),'root');        
            if($verificar){ //el booleano verificar indica si se verificara por datos repetidos
                $sentencia = $pdo->prepare('INSERT INTO ' . $tabla . ' 
                (dni,nombre,apellido,sexo,legajo,sueldo,turno,pathFoto) 
                VALUES (dni=:dni,nombre=:nombre,apellido=:apellido,sexo=:sexo,legajo=:legajo,
                sueldo=:sueldo,turno=:turno,pathFoto=:pathFoto');
            }else{ //se supone que se use solo en la tabla de borrados esta sentencia
                $sentencia = $pdo->prepare('INSERT INTO ' . $tabla . ' 
                (id,dni,nombre,apellido,sexo,legajo,sueldo,turno,pathFoto) 
                VALUES (id=:id,dni=:dni,nombre=:nombre,apellido=:apellido,sexo=:sexo,legajo=:legajo,
                sueldo=:sueldo,turno=:turno,pathFoto=:pathFoto');
                $sentencia->bindValue(':id', $emp->GetId(), PDO::PARAM_INT);
            }*/
            $pdo = new PDO(ConectionString());
            $sentencia = $pdo->prepare('INSERT INTO ' . $tabla . ' 
                (dni,nombre,apellido,sexo,legajo,sueldo,turno,pathFoto) 
                VALUES (dni=:dni,nombre=:nombre,apellido=:apellido,sexo=:sexo,legajo=:legajo,
                sueldo=:sueldo,turno=:turno,pathFoto=:pathFoto');
            $sentencia->bindValue(':dni', $emp->dni, PDO::PARAM_INT);
            $sentencia->bindValue(':nombre', $emp->nombre, PDO::PARAM_STR);
            $sentencia->bindValue(':apellido', $emp->apellido, PDO::PARAM_STR);
            $sentencia->bindValue(':sexo', $emp->sexo, PDO::PARAM_STR);
            $sentencia->bindValue(':legajo', $emp->legajo, PDO::PARAM_INT);
            $sentencia->bindValue(':sueldo', $emp->sueldo, PDO::PARAM_STR);
            $sentencia->bindValue(':turno', $emp->turno, PDO::PARAM_STR);
            $sentencia->bindValue(':pathFoto', $emp->pathFoto, PDO::PARAM_STR);
            $sentencia->execute();
            unset($pdo);
        }
    }
    /**Remueve un empleado de la tabla principal y lo carga en la tabla de borrados */
    function DB_Eliminar($emp){
        $out = DB_Traer($emp->GetDni());
        DB_Agregar($out, 'borrados', false);
        $pdo = new PDO(ConectionString());
        $sentencia = $pdo->prepare('DELETE FROM empleados WHERE id=:id');
        $sentencia->bindValue(':id', $emp->GetId(), PDO::PARAM_INT);
        $sentencia->execute();
        unset($pdo);
    }
    /**Trae un objeto empleado de una tabla donde coincida el DNI */
    function DB_Traer($dni, $table = 'empleados'){
        try{
            $pdo = new PDO(ConectionString());
            $sentencia = $pdo->prepare('SELECT * FROM ' . $table .'  WHERE dni=:dni');
            $sentencia->bindValue(':dni', $dni, PDO::PARAM_STR);
            $sentencia->execute();            
            $dataRow = $sentencia->fetchObject();
            var_dump($dataRow);
            $emp = new Empleado($dataRow->nombre, 
                                $dataRow->apellido, 
                                $dataRow->dni, 
                                $dataRow->sexo, 
                                $dataRow->legajo, 
                                $dataRow->sueldo,
                                $dataRow->turno);
                                $emp->SetPathFoto($dataRow->pathFoto);
                                $emp->SetId($dataRow->id);
            var_dump($emp);
        }catch(Exception $e){
            $f = fopen('./dump.txt', 'a');
            fwrite($f, $e->message . "\n");
            fclose($f);
        }finally{
            unset($pdo);
            return $emp;
        }
    }
    function DB_TraerTodos($table = 'empleados'){
        $pdo = new PDO(ConectionString());
        $sentencia = $pdo->prepare('SELECT * FROM ' . $table);
        $sentencia->execute();
        $array_objects = array();
        while($dataRow = $sentencia->fetchObject()){
            $emp = new Empleado($dataRow->nombre, 
                            $dataRow->apellido, 
                            intval($dataRow->dni), 
                            $dataRow->sexo, 
                            intval($dataRow->legajo), 
                            floatval($dataRow->sueldo),
                            $dataRow->turno);
                            $emp->SetPathFoto($dataRow->pathFoto);
                            $emp->SetId($dataRow->id);
            array_push($array_objects, $emp);
        }
        return $array_objects;
    }
    /**Verifica si el dni de un empleado ya esta en la DB */
    function VerificarExistencia($dni, $table = "empleados"){
        $pdo = new PDO(ConectionString());
        $sentencia = $pdo->prepare('SELECT * FROM ' . $table .'  WHERE dni=:dni');
        $sentencia->bindValue(':dni', $dni, PDO::PARAM_INT);
        $sentencia->execute();
        unset($pdo);
        if($sentencia->fetchObject() != null){
            return true;
        }else{
            return false;
        }
    }
?>