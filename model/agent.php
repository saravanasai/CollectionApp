<?php
 
 class Agents{
    
    //variables for table insertion 
    public $agentname;
    public $agentPhoneNumber;
    public $agentLocation;
    public $agent_id;
    private $conn;
    //tables
    private $table_name;
    private $table_place;
    public function __construct($db)
    {
         $this->conn=$db;
         $this->table_name='agent_master';
         $this->table_place='place_master';
    }
    
    //function parts

 
    public function check_agent_exist()
    {
        $sql="SELECT * FROM ".$this->table_name." WHERE  AGENT_NAME ='".$this->agentname."' AND `AGENT_DL_STATUS`=1";
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
    public function insert_agent()
    {
       
        $sql="INSERT INTO ".$this->table_name."(`AGENT_NAME`,`AGENT_PH_NO`,`AGENT_LOCATION`) VALUES ('".$this->agentname."','".$this->agentPhoneNumber."','".$this->agentLocation."')";
        $stmt=$this->conn->prepare($sql);  
        try{
              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function get_all_agent()
    {
       
        $sql="SELECT `AGENT_ID`,`AGENT_NAME`,`AGENT_PH_NO`,`AGENT_LOCATION`,`PLACE_NAME` FROM ".$this->table_name.",".$this->table_place." WHERE `AGENT_DL_STATUS`=1 AND `AGENT_LOCATION`=".$this->table_place.".PLACE_ID";
        $stmt=$this->conn->prepare($sql); 
        try{
         $stmt->execute();
         $all_agents_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         return $all_agents_fetched;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function delete_agent()
    {
        $sql="UPDATE ".$this->table_name." SET `AGENT_DL_STATUS`=0 WHERE `AGENT_ID`=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('id',$this->agent_id);
         
        try{
           
            return ( $stmt->execute())?true:false;
            
        }catch(PDOException $e)
        {
            echo $e;
        }
          
    }
 }


?>