<?php
    class Database{
        private $dbHost = DB_HOST;
        private $dbUser = DB_USER;
        private $dbPass = DB_PASS;
        private $dbName = DB_NAME;

        private $stament;
        private $dbHandler;
        private $error;

        public function __construct()
        {
            $conn = 'mysql:host='.$this->dbHost.';dbname='.$this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            );
            try{
                $this->dbHandler = new PDO($conn, $this->dbUser,$this->dbPass); 
            }catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        public function query($sql){
            $this->stament = $this->dbHandler->prepare($sql);

        }

        public function bind($paramater,$value,$type=null){
            switch(is_null($type)){
                case is_int($value):{
                    $type = PDO::PARAM_INT;
                    break;
                }
                case is_bool($value):{
                    $type = PDO::PARAM_BOOL;
                    break;
                }
                case is_null($value):{
                    $type = PDO::PARAM_NULL;
                    break;
                }
                default:
                    $type = PDO::PARAM_STR;
            }

            $this->stament->bindValue($paramater, $value, $type);
        }

        // excuted the prepare statement
        public function execute(){
            return $this->stament->execute();
        }
        // return an array
        public function resultSet(){
            $this->execute();
            return $this->stament->fetch(PDO::FETCH_ASSOC);
        }
        //returl a specific row as an object
        public function single(){
            $this->execute();
            return $this->stament->fetch(PDO::FETCH_OBJ);
        }
        public function singleAll(){
            $this->execute();
            return $this->stament->fetchAll(PDO::FETCH_OBJ);
        }
        // Get's the row count
        public function rowCount() {
            $this->execute();
            return $this->stament->rowCount();
        }
    }