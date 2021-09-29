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
   
    $or_amount=$amount_paid;
    $sql="CALL get_collection_of_customer(:id)";
    $stmt=$this->conn->prepare($sql);
    $stmt->bindParam('id',$cus_id,PDO::PARAM_INT);
    $stmt->execute();
    $customer_details_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    //calcuation the total amount to find the due months
    $plan_amount=$customer_details_fetched[0]["PL_AMOUNT"];
    $this->plan_id=$customer_details_fetched[0]["COL_TB_CUS_PL"];
    $balance_due_months=$customer_details_fetched[0]["CL_BALANCE_DUE_MONTH"];  
         
            $pay_for_month=$this->months-$balance_due_months;
            $check_payment_on_existing_month=$pay_for_month-1;
                  if($check_payment_on_existing_month==0)
                  {
                     $check_payment_on_existing_month=1;
                  }
                  $paid_less_than_plan=false;
               //section if lastmonth pending is avaliable or not
                  $sql_to_check_last_payment="SELECT CL_FOR_MONTH_".$check_payment_on_existing_month." FROM ".$this->table_name." WHERE CL_FOR_MONTH_".$check_payment_on_existing_month."<".$plan_amount." AND CL_FOR_MONTH_".$check_payment_on_existing_month." !=0";
                  $stmt_to_check_last_payment=$this->conn->prepare($sql_to_check_last_payment);
                  $stmt_to_check_last_payment->execute();
                  $existing_pending_amount=$stmt_to_check_last_payment->rowCount();
                  if($existing_pending_amount>0)
                  {
                     
                     $last_balance_amount_fetch=$stmt_to_check_last_payment->fetchall(PDO::FETCH_ASSOC);
                     $last_balance=$last_balance_amount_fetch[0]["CL_FOR_MONTH_".$check_payment_on_existing_month];
                     $amount_paid=$amount_paid-$last_balance;
                     
                     $sql_to_update_last_payment="UPDATE ".$this->table_name." SET  CL_FOR_MONTH_".$check_payment_on_existing_month."=".$plan_amount.",CL_BALANCE_DUE_MONTH=".$balance_due_months." ,CL_LAST_PAID_TO=".$this->by_admin." WHERE CL_FOR_MONTH_".$check_payment_on_existing_month."<".$plan_amount." ";
                     $stmt_to_update_last_payment=$this->conn->prepare($sql_to_update_last_payment);
                      if($stmt_to_update_last_payment->execute())
                      {
                         $sql="INSERT INTO `transaction_master`(`TR_OF_CUS`, `TR_OF_PL_ID`, `TR_DONE_TO`, `TR_PAID_AMOUNT`) VALUES (".$cus_id.",".$this->plan_id.",".$this->by_admin.",".$plan_amount.")";
                         $stmt_for_update_transaction=$this->conn->prepare($sql);
                         $stmt_for_update_transaction->execute();
                      }
                  
                  }   
                  //end of section if lastmonth pending is avaliable or not
               
                  //finding customre paid amount is less than a plan amount 
                  if($amount_paid<$plan_amount)
                  {
                     $paid_less_than_plan=true;
                  }
                  //end finding customre paid amount is less than a plan amount   
                  $count=$amount_paid/$plan_amount;
                  $count=floor($count);
               //find the amount paid by customer is excess or not
                  $amount_excess=$amount_paid%$plan_amount;
                  $excess_amount_exist=false;
                  if($amount_excess!=0)
                  {
                     $excess_amount_exist=true;
                     $count++;
                  } 
               //end of find the amount paid by customer is excess or not       
               //section for updating the collection_master_list 
            for ($i=0; $i <$count ; $i++) 
            { 
                  --$balance_due_months;
                  ($balance_due_months<0)?$balance_due_months=0:$balance_due_months;
                  if($excess_amount_exist)
                  {
                     if($i==$count-1)
                     {
                        $sql_to_update="UPDATE collection_master SET CL_FOR_MONTH_".$pay_for_month."=".$amount_excess.",CL_BALANCE_DUE_MONTH=".$balance_due_months.",CL_LAST_PAID_TO=".$this->by_admin." WHERE  COL_FOR_CUS_ID=:cus_id";
                        $stmt_to_update=$this->conn->prepare($sql_to_update);
                        $stmt_to_update->bindParam('cus_id',$cus_id,PDO::PARAM_INT);
                        if($stmt_to_update->execute())
                        {
                           $pay_for_month=$this->months-$balance_due_months;
                        }   
                     }
                     else{
                        $sql_to_update="UPDATE collection_master SET CL_FOR_MONTH_".$pay_for_month."=".$plan_amount.",CL_BALANCE_DUE_MONTH=".$balance_due_months.",CL_LAST_PAID_TO=".$this->by_admin." WHERE  COL_FOR_CUS_ID=:cus_id";
                        $stmt_to_update=$this->conn->prepare($sql_to_update);
                        $stmt_to_update->bindParam('cus_id',$cus_id,PDO::PARAM_INT);
                        if($stmt_to_update->execute())
                        {
                           $pay_for_month=$this->months-$balance_due_months;
                        }
                        
                     }
                     
                  }
                  else if($paid_less_than_plan){
                     $sql_to_update="UPDATE collection_master SET CL_FOR_MONTH_".$pay_for_month."=".$amount_paid.",CL_BALANCE_DUE_MONTH=".$balance_due_months.",CL_LAST_PAID_TO=".$this->by_admin." WHERE  COL_FOR_CUS_ID=:cus_id";
                     $stmt_to_update=$this->conn->prepare($sql_to_update);
                     $stmt_to_update->bindParam('cus_id',$cus_id,PDO::PARAM_INT);
                     if($stmt_to_update->execute())
                     {  
                        $pay_for_month=$this->months-$balance_due_months;
                     }
                    
                  }
                  else{

                     $sql_to_update="UPDATE collection_master SET CL_FOR_MONTH_".$pay_for_month."=".$plan_amount.",CL_BALANCE_DUE_MONTH=".$balance_due_months.",CL_LAST_PAID_TO=".$this->by_admin." WHERE  COL_FOR_CUS_ID=:cus_id";
                     $stmt_to_update=$this->conn->prepare($sql_to_update);
                     $stmt_to_update->bindParam('cus_id',$cus_id,PDO::PARAM_INT);
                     if($stmt_to_update->execute())
                     {
                        $pay_for_month=$this->months-$balance_due_months;
                     }
                    
                  }
               
               
            }
             
            $sql="INSERT INTO `transaction_master`(`TR_OF_CUS`, `TR_OF_PL_ID`, `TR_DONE_TO`, `TR_PAID_AMOUNT`) VALUES (".$cus_id.",".$this->plan_id.",".$this->by_admin.",".$or_amount.")";
            $stmt_for_update_transaction=$this->conn->prepare($sql);
            $stmt_for_update_transaction->execute();      
            return true;

 }    

}




?>