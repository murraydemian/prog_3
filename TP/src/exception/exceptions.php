<?PHP
    class EmpleadoRepetidoException extends Exception{
        function __construct(){
            return new Exception('El empleado ya existe.');
        }
    }
    class EmpleadoInexistenteException extends Exception{
        function __construct(){
            return new Exception('El empleado no existe.');
        }
    }
?>