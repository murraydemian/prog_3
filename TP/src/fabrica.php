<?php 
    //namespace TP_Parte_1;


    class Fabrica implements IArchivo{

        private $_cantidadMaxima;
        private $_empleados;
        private $_razonSocial;

        public function __construct($razonSocial, $capacidad){
            if(isset($capacidad)){
                $this->_cantidadMaxima = $capacidad;
            }
            else{
                $this->_cantidadMaxima = 5;
            }
            $this->_empleados = array();
            $this->_razonSocial = $razonSocial;
        }
        public function GetEmpleados(){
            return $this->_empleados;
        }
        public function AgregarEmpleado($emp){
            $seAgrego = false;
            if(count($this->_empleados) < $this->_cantidadMaxima){
                array_push($this->_empleados, $emp);
                $this->EliminarEmpleadoRepetido();
                $seAgrego = true;
            }
            return $seAgrego;
        }
        public function CalcularSueldos(){
            $obligacionSalarial = 0;
            foreach($this->_empleados as $emp){
                $obligacionSalarial = $obligacionSalarial + $emp->GetSueldo();
            }
            return $obligacionSalarial;
        }
        public function EliminarEmpleado($emp){
            $seElimino = false;
            $index = $this->IndiceEmpleado($emp);
            if($index >= 0){
                unset($this->_empleados[$index]);
            }
            return $seElimino;
        }
        public function EliminarEmpleadoPorLegajo($leg){
            $seElimino = false;            
            if(isset($leg)){
                foreach ($this->_empleados as $index => $item) {
                    if($this->_empleados[$index]->GetLegajo() == $leg){
                        unset($this->_empleados[$index]);
                        $seElimino = true;
                        break;
                    }
                }
            }
            return $seElimino;
        }
        public function TrearPorLegajo($leg){
            $emp = null;            
            if(isset($leg)){
                foreach ($this->_empleados as $index => $item) {
                    if($this->_empleados[$index]->GetLegajo() == $leg){
                        $emp = $this->_empleados[$index];  
                        break;                      
                    }
                }
            }
            return $emp;
        }
        public function TraerPorDNI($dni){
            $emp = null;            
            if(isset($dni)){
                foreach ($this->_empleados as $index => $item) {
                    if($this->_empleados[$index]->GetDni() == $dni){
                        $emp = $this->_empleados[$index]; 
                        break;                       
                    }
                }
            }
            return $emp;
        }
        private function EliminarEmpleadoRepetido(){
            $this->_empleados = array_unique($this->_empleados, SORT_REGULAR);
        }
        public function ToString(){
            $strFabrica = "Capacidad: " . $this->_cantidadMaxima . "<BR>Empleados:<BR>";
            foreach($this->_empleados as $item){
                $strFabrica = $strFabrica . $item->ToString() . "<BR>";
            }
            $strFabrica = $strFabrica . "Razon social: " . $this->_razonSocial;
            return $strFabrica;
        }
        private function IndiceEmpleado($emp){
            $index = -1;
            foreach ($this->_empleados as $i => $item) {
                if($this->_empleados[$i]->GetLegajo() == $emp->GetLegajo()){
                    $index = $i;
                }
            }
            return $index;
        }

        public function GuardarEnArchivo($nombreArchivo){
            $file = fopen($nombreArchivo, "w");
            foreach($this->_empleados as $emp){                
                fwrite($file, "\r\n" . $emp->ToString());
            }            
            fclose($file);
        }
        public function TraerDeArchivo($nombreArchivo){
            $file = fopen($nombreArchivo, "r");
            $strEmps = Fabrica::Convertir_ArchivoAString($file);
            $array_EmpStr = explode("|", $strEmps);
            $len = count($array_EmpStr);
            for($i = 0; $i < $len; $i++){
                $empObj = Fabrica::Convertir_StringAEmpleado($array_EmpStr[$i]);
                $this->AgregarEmpleado($empObj);
            }
            fclose($file);
        }
        public static function TraerDesdeArchivo($nombreArchivo){
            $f = new Fabrica("", 10000);
            $f->TraerDeArchivo($nombreArchivo);
            return $f;
        }
        /**Convierte una string con un formato especifico en un objeto tipo Empleado y lo retorna 
         * El formato es el siguiente: apellido-nombre-dni-sexo-legajo-sueldo-turno
        */
        private static function Convertir_StringAEmpleado($string_Empleado){        
            $empObj = null;
            if($string_Empleado != null){
                $empStr = explode("-", $string_Empleado);         
                $empObj = new Empleado(
                    $empStr[1], //Apellido
                    $empStr[0], //Nombre
                    $empStr[2], //DNI
                    $empStr[3], //Sexo
                    $empStr[4], //Legajo
                    $empStr[5], //Sueldo
                    $empStr[6]  //Turno
                );      
                $empObj->SetPathFoto($empStr[7]);          
            }
            return $empObj;        
        }
        /**Lee todos los empleados guardados en el archivo y los separa usando el caracter |
         * Retorna el string resultante
         */
        private static function Convertir_ArchivoAString($file){
            $strEmps = "";
            if($file != null){
                $line = "";
                while(!feof($file)){
                    $line = trim(fgets($file));
                    if(!empty($line)){
                        $strEmps = $strEmps . $line . "|";        
                    }            
                }
                $strEmps = substr($strEmps, 0, strlen($strEmps)-1); //Remuevo el | despues del ultimo empleado ya que no necesito separarlo de otro               
            }
            return $strEmps;
        }
    }

?>