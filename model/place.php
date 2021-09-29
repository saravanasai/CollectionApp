<?php
 
 class Places{
    
    //variables for table insertion 
    public $placename;
    private $conn;
    //tables
    private $table_name;
    public function __construct($db)
    {
         $this->conn=$db;
         $this->table_name='place_master';
    }
    
    //function parts

 
    public function check_place_exist()
    {
        $sql="SELECT * FROM ".$this->table_name." WHERE PLACE_NAME='".$this->placename."'";
        $stmt=$this->conn->prepare($sql);
       try{
               $stmt->execute();
               $response=$stmt->fetchall(PDO::FETCH_ASSOC);
               return (count($response)>0)?false:true;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function insert_place()
    {
       
        $sql="INSERT INTO ".$this->table_name."(`PLACE_NAME`) VALUES ('".$this->placename."')";
        $stmt=$this->conn->prepare($sql);
       
         
        try{
              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function get_all_place()
    {
       
        $sql="SELECT `PLACE_ID`,`PLACE_NAME` FROM ".$this->table_name." ";
        $stmt=$this->conn->prepare($sql);
       
         
        try{
         $stmt->execute();
         $all_places_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         return $all_places_fetched;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
 }


?>