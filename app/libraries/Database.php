<?php
    /*
     * PDO Database class
     * Connect to the database
     * Create prepared statements
     * Bind values
     * Return rows
     */
    class Database
    {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbhandler;
        private $stmt;
        private $error;

        public function __construct()
        {
            //Set Data Source Name
            $dsn = 'mysql:host'.$this->host.';dbname'.$this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            //Create PDO instance
            try {
                $this->dbhandler = new PDO($dsn,$this->user,$this->pass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
            //Set used db as /mvcframework/
            //Change this to current db name when working with production
            $this->dbhandler->prepare('USE mvcframework;')->execute();
        }
        //Prepare statement with query
        public function query($sql)
        {
            try {
                $this->stmt = $this->dbhandler->prepare($sql);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();}
        }

        //Bind values
        function bind($param, $value, $type = null){
            if(is_null($type)){
                switch (true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        //Execute the prepared statement

        public function execute()
        {
            return $this->stmt->execute();
        }

        // Get the result set as an array of objects
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        // Get single record as object
        public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }
        //Get row count
        public function rowCount()
        {
            return $this->stmt->rowCount();
        }

    }