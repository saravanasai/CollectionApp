<?php
 
 class Plans{
    
    //variables for table insertion 
    public $planeamount;
    private $conn;
    //tables
    private $table_name;
    public function __construct($db)
    {
         $this->conn=$db;
         $this->table_name='plan_master';
    }
    
    //function parts

 
    public function check_Plan_exist()
    {
        $sql="SELECT * FROM ".$this->table_name." WHERE  PL_AMOUNT  ='".$this->planeamount."'";
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
    public function insert_plan()
    {
       
        $sql="INSERT INTO ".$this->table_name."(`PL_AMOUNT`) VALUES ('".$this->planeamount."')";
        $stmt=$this->conn->prepare($sql);
       
         
        try{
              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function get_all_plan()
    {
       
        $sql="SELECT `PL_ID`,`PL_AMOUNT` FROM ".$this->table_name." ";
        $stmt=$this->conn->prepare($sql);
       
         
        try{
         $stmt->execute();
         $all_plans_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         return $all_plans_fetched;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
 }


?>