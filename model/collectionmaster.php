<?php 

class collection_list
{
  
  private $conn;
  private $table_name;
  private $months;
  private $plan_id;
  
  public $by_admin;
  public function __construct($db)
  {
      $this->conn=$db;
      $this->table_name="collection_master";
      $this->months=12;
     
  }


 public function all_collection_list()
 {
    $final_list=[];
    $sql="CALL super_collection_list()";
    $stmt=$this->conn->prepare($sql);
    $stmt->execute();
    $collection_list_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
    $collection_list_data=array();
     for ($i=0; $i<count($collection_list_fetched) ; $i++) { 
        
        $collection_list_data[$i]["CUS_ID"]=$collection_list_fetched[$i]["CUS_ID"];
        $collection_list_data[$i]["CUS_NAME"]=$collection_list_fetched[$i]["CUS_NAME"];
        $collection_list_data[$i]["CUS_SUR_NAME"]=$collection_list_fetched[$i]["CUS_SUR_NAME"];
        $collection_list_data[$i]["CUS_PHONE_NUMBER"]=$collection_list_fetched[$i]["CUS_PM_PH_NO"];
        $collection_list_data[$i]["CUS_PLAN_AMOUNT"]=$collection_list_fetched[$i]["PL_AMOUNT"];
        $collection_list_data[$i]["CUS_MON_1"]=$collection_list_fetched[$i]["CL_FOR_MONTH_1"];
        $collection_list_data[$i]["CUS_MON_2"]=$collection_list_fetched[$i]["CL_FOR_MONTH_2"];
        $collection_list_data[$i]["CUS_MON_3"]=$collection_list_fetched[$i]["CL_FOR_MONTH_3"];
        $collection_list_data[$i]["CUS_MON_4"]=$collection_list_fetched[$i]["CL_FOR_MONTH_4"];
        $collection_list_data[$i]["CUS_MON_5"]=$collection_list_fetched[$i]["CL_FOR_MONTH_5"];
        $collection_list_data[$i]["CUS_MON_6"]=$collection_list_fetched[$i]["CL_FOR_MONTH_6"];
        $collection_list_data[$i]["CUS_MON_7"]=$collection_list_fetched[$i]["CL_FOR_MONTH_7"];
        $collection_list_data[$i]["CUS_MON_8"]=$collection_list_fetched[$i]["CL_FOR_MONTH_8"];
        $collection_list_data[$i]["CUS_MON_9"]=$collection_list_fetched[$i]["CL_FOR_MONTH_9"];
        $collection_list_data[$i]["CUS_MON_10"]=$collection_list_fetched[$i]["CL_FOR_MONTH_10"];
        $collection_list_data[$i]["CUS_MON_11"]=$collection_list_fetched[$i]["CL_FOR_MONTH_11"];
        $collection_list_data[$i]["CUS_MON_12"]=$collection_list_fetched[$i]["CL_FOR_MONTH_12"];
        // $collection_list_data[$i]["BAL_DUE_MON"]=$collection_list_fetched[$i]["CL_BALANCE_DUE_MONTH"];
          
     } 
     for ($j=0; $j <count($collection_list_data) ; $j++) 
     { 
         
          $final_list[$j]=$collection_list_data[$j];
         
     }
    
      return $final_list;
 } 
 public function pay_due($cus_id,$amount_paid)
 {
   
 }    

}




?>