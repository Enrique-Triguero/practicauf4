<?php

    namespace jesusyenrique\practicauf4;
    
    // conexión con la BBDD
    class DBconn{
        private $host;
        private $dbname;
        private $user;
        private $password;
        public $conn;

        public function __construct(){
            $this->host = 'localhost';
            $this->dbname = 'practica_uf4';
            $this->user = '';
            $this->password = '';
        }

        public function connect(){
            $this->conn = null;

            try{
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOEXCEPTION $e){
                echo 'Connection failed: '.$e->getMessage();
            }
            return $this->conn;
        }
    }
?>
