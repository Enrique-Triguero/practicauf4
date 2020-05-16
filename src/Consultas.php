<?php
    
    namespace jesusyenrique\practicauf4;

    include 'DBconn.php';

    class Consultas extends DBconn{

        // recuperamos los datos del cliente
        function consultaCliente($nombre){
            $result = $this->connect()->query("SELECT * FROM ventas WHERE nombre LIKE '" . $nombre . "';");
            return $result;
        }

        // recuperamos los datos de la fecha asignada
        function consultaFechas($fecha) {
            $result = $this->connect()->query("SELECT * FROM ventas WHERE fecha >= '" . $fecha . "';");
            return $result;
        }
    }
?>
