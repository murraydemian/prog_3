<?PHP
    include_once "./exception/exceptions.php";
    include_once './clases/persona.php';
    include_once './clases/empleado.php';


    //DB_Traer(39514859, 'empleados');
    /**Retorna la cadena de coneccion a la base de datos */
    function Conection(){
        $str = 'mysql:host=us-cdbr-east-06.cleardb.net;dbname=heroku_2954a8369d74e12';
        $usr = 'ba240b2269e03a';
        $psw = '426cc9b3';
        return new PDO($str, $usr, $psw);
    }
    /**Agrega un empleado a la DB */
    function DB_Agregar($emp, $tabla = "empleados", $verificar = true){
        $pdo = Conection();
        $sentencia = $pdo->prepare('INSERT INTO ' . $tabla . 
            '(dni,nombre,apellido,sexo,legajo,sueldo,turno,pathFoto) ' .
            'VALUES (:dni,:nombre,:apellido,:sexo,:legajo,' .
            ':sueldo,:turno,:pathFoto)');
        $sentencia->bindValue(':dni', intval($emp->dni), PDO::PARAM_INT);
        $sentencia->bindValue(':nombre', $emp->nombre, PDO::PARAM_STR);
        $sentencia->bindValue(':apellido', $emp->apellido, PDO::PARAM_STR);
        $sentencia->bindValue(':sexo', $emp->sexo, PDO::PARAM_STR);
        $sentencia->bindValue(':legajo', intval($emp->legajo), PDO::PARAM_INT);
        $sentencia->bindValue(':sueldo', $emp->sueldo, PDO::PARAM_STR);
        $sentencia->bindValue(':turno', $emp->turno, PDO::PARAM_STR);
        $sentencia->bindValue(':pathFoto', $emp->pathFoto, PDO::PARAM_STR);
        $t = $sentencia->execute();
        /*///
            var_dump($emp);
            $res = ob_get_clean();
            $f = fopen('./dump.html', 'w');
            fwrite($f, $res);
            fclose($f);
        ///*/   
        unset($pdo);
        return $t;        
    }
    /**Trae un objeto empleado de una tabla donde coincida el DNI */
    function DB_Traer($dni, $table = 'empleados'){
        try{
            $pdo = Conection();
            $sentencia = $pdo->prepare('SELECT * FROM ' . $table .'  WHERE dni=:dni');
            $sentencia->bindValue(':dni', $dni, PDO::PARAM_STR);
            $sentencia->execute();            
            $dataRow = $sentencia->fetchObject();
            //var_dump($dataRow);
            if($dataRow){
                $emp = new Empleado($dataRow->nombre, 
                    $dataRow->apellido, 
                    $dataRow->dni, 
                    $dataRow->sexo, 
                    $dataRow->legajo, 
                    $dataRow->sueldo,
                    $dataRow->turno);
                $emp->SetPathFoto($dataRow->pathFoto);
                $emp->SetId($dataRow->id);
                //var_dump($emp);
            }else{
                $emp = null;
            }
        }catch(Exception $e){
            $f = fopen('./dump.txt', 'a');
            fwrite($f, $e->GetMessage(). "\n");
            fclose($f);
        }finally{
            unset($pdo);
            return $emp;
        }
    }
    function DB_TraerTodos($table = 'empleados'){
        $pdo = Conection();
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
        /*///
            var_dump($array_objects);
            $res = ob_get_clean();
            $f = fopen('./dump.html', 'w');
            fwrite($f, $res);
            fclose($f);
        ///*/
        unset($pdo);
        return $array_objects;
    }
    /**Verifica si el dni de un empleado ya esta en la DB */
    function VerificarExistencia($dni, $table = "empleados"){
        $pdo = Conection();
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
    function DB_Modificar($emp, $table = "empleados"){
        $pdo = Conection();
        $sentencia = $pdo->prepare('UPDATE '.$table.' 
            SET nombre=:nombre,pathFoto=:pathFoto,apellido=:apellido,sexo=:sexo,legajo=:legajo,sueldo=:sueldo,turno=:turno 
            WHERE dni=:dni');
        $sentencia->bindValue(':nombre', $emp->nombre, PDO::PARAM_STR);
        $sentencia->bindValue(':pathFoto', $emp->pathFoto, PDO::PARAM_STR);
        $sentencia->bindValue(':apellido', $emp->apellido, PDO::PARAM_STR);
        $sentencia->bindValue(':sexo', $emp->sexo, PDO::PARAM_STR);
        $sentencia->bindValue(':legajo', intval($emp->legajo), PDO::PARAM_INT);
        $sentencia->bindValue(':sueldo', $emp->sueldo, PDO::PARAM_STR);
        $sentencia->bindValue(':turno', $emp->turno, PDO::PARAM_STR);
        $sentencia->bindValue(':dni', intval($emp->dni), PDO::PARAM_INT);
        $t = $sentencia->execute();
        unset($pdo);
        return $t;
    }
    function DB_Eliminar($id, $table = "empleados"){
        $pdo = Conection();
        $sentencia = $pdo->prepare('DELETE FROM empleados WHERE id=:id');
        $sentencia->bindValue(':id', $id, PDO::PARAM_INT);
        $t = $sentencia->execute();
        unset($pdo);
        return $t;
    }
?>