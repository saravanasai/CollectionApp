<?php

 class Database{


   private $servername;
   private $dbname;
   private $username;
   private $password;
   private $conn;
        public function Connect()
          {
            $this->servername='localhost';
            $this->dbname='api';
            $this->username='root';
            $this->password='';
            try {
              $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username, $this->password);
              // set the PDO error mode to exception
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              // echo "Connected successfully";
              return $this->conn;
            } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }

          }

  }



 ?>