<?php
 
class Due{
 
 
  private $conn;
  //table variable
  private $collection_master;
  private $customer_master;
  private $plan_master;
  private $place_master;
  private $scheme_master;

  public $selected_plan_id;
  public $less_than_amount;

  public function __construct($db)
  {
     $this->conn=$db;
     $this->collection_master="collection_master";
     $this->customer_master="customer_master";
     $this->plan_master="plan_master";
     $this->place_master="place_master";
     $this->scheme_master="scheme_master";
      
  }
    //functions to perform tasks


  public function get_balance_due_list()
  {
        $sql="SELECT * FROM ".$this->collection_master." 
        INNER JOIN ".$this->customer_master." ON ".$this->collection_master.".COL_FOR_CUS_ID=customer_master.CUS_ID
        INNER JOIN ".$this->plan_master." ON ".$this->plan_master.".PL_ID=".$this->customer_master.".CUS_PLAN_ID
        INNER JOIN ".$this->place_master." ON ".$this->place_master.".PLACE_ID=".$this->customer_master.".CUS_PLACE_ID
        INNER JOIN ".$this->scheme_master." ON ".$this->scheme_master.".SCHEME_ID=".$this->customer_master.".CUS_SCHEME_ID
        WHERE ".$this->customer_master.".CUS_PLAN_ID=:pl_id AND ".$this->collection_master.".COL_DUE_BALANCE>:amount";

        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam('pl_id',$this->selected_plan_id);
        $stmt->bindParam('amount',$this->less_than_amount);

        try
        {
            if($stmt->execute())
            {
                $due_list_fetch=$stmt->fetchall(PDO::FETCH_ASSOC);
                return $due_list_fetch;

            }

        }catch(PDOException $e)
        {
            echo $e;
        }
        
        
  }
   
}
  


?>