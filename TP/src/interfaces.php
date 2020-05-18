<?php 
    //namespace TP_Parte_1;

    interface IArchivo{
        function GuardarEnArchivo($nombreArchivo);
        function TraerDeArchivo($nombreArchivo);
    }
?>