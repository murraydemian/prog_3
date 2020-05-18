<?php 
    //namespace TP_Parte_1;

    class Empleado extends Persona{


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
        
        public function SetPathFoto($foto){
            $this->_path = $foto;
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
    }
?>