<?php 
    //namespace TP_Parte_1;

    class Empleado extends Persona{

        protected $_id;
        protected $_legajo;
        protected $_sueldo;
        protected $_turno;
        protected $_path;

        function __construct($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno){
            parent::__construct($nombre, $apellido, $dni, $sexo);
            $this->_legajo = $legajo;
            $this->_sueldo = $sueldo;
            $this->_turno = $turno;
        }

        public function GetLegajo(){
            return $this->_legajo;
        }
        public function GetSueldo(){
            return $this->_sueldo;
        }
        public function GetTurno(){
            return $this->_turno;
        }
        public function GetPathFoto(){
            return $this->_path;
        }
        public function GetId(){
            return $this->_id;
        }
        
        public function SetPathFoto($foto){
            $this->_path = $foto;
        }
        public function SetId($id){
            $this->_id = $id;
        }
        

        public function Hablar($idioma){
            $habla = "El empleado habla ";
            foreach($idioma as $item){
                $habla = $habla . $item . ", ";
            }
            $habla = substr($habla, 0, strlen($habla) - 2);
            $habla = $habla . ".";
            return $habla;
        }
        public function ToString(){
            return parent::ToString() . "-" . $this->_legajo . "-" . $this->_sueldo . "-" . $this->_turno . "-" . $this->_path;
        }
        public function ToJSON(){
            $dni = $this->GetDni();
            $nombre = $this->GetNombre();
            $apellido = $this->GetApellido();
            $sexo = $this->GetSexo();
            $legajo = $this->GetLegajo();
            $sueldo = $this->GetSueldo();
            $turno = $this->GetTurno();
            $path = $this->GetPathFoto();
            return '{"dni":"'.$dni.'","nombre":"'.$nombre.'","apellido":"'.$apellido.'","sexo":"'.$sexo.'","legajo":"'.$legajo.'","sueldo":"'.$sueldo.'","turno":"'.$turno.'","pathFoto":"'.$path.'"}';
        }
    }
?>