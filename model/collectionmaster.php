<?php

class collection_list
{

   private $conn;
   private $table_name;
   private $trascation;
   private $months;
   private $plan_id;

   public $by_admin;
   public function __construct($db)
   {
      $this->conn = $db;
      $this->table_name = "collection_master";
      $this->months = 12;
      $this->trascation = "transaction_master";

   }

   public function all_collection_list()
   {
      $final_list = [];
      $sql = "CALL super_collection_list()";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $collection_list_fetched = $stmt->fetchall(PDO::FETCH_ASSOC);
      $collection_list_data = array();
      for ($i = 0; $i < count($collection_list_fetched); $i++) {

         $collection_list_data[$i]["CUS_ID"] = $collection_list_fetched[$i]["CUS_ID"];
         $collection_list_data[$i]["CUS_NAME"] = $collection_list_fetched[$i]["CUS_NAME"];
         $collection_list_data[$i]["CUS_SUR_NAME"] = $collection_list_fetched[$i]["CUS_SUR_NAME"];
         $collection_list_data[$i]["CUS_PHONE_NUMBER"] = $collection_list_fetched[$i]["CUS_PM_PH_NO"];
         $collection_list_data[$i]["CUS_PLAN_AMOUNT"] = $collection_list_fetched[$i]["PL_AMOUNT"];
         $collection_list_data[$i]["CUS_MON_1"] = $collection_list_fetched[$i]["CL_FOR_MONTH_1"];
         $collection_list_data[$i]["CUS_MON_2"] = $collection_list_fetched[$i]["CL_FOR_MONTH_2"];
         $collection_list_data[$i]["CUS_MON_3"] = $collection_list_fetched[$i]["CL_FOR_MONTH_3"];
         $collection_list_data[$i]["CUS_MON_4"] = $collection_list_fetched[$i]["CL_FOR_MONTH_4"];
         $collection_list_data[$i]["CUS_MON_5"] = $collection_list_fetched[$i]["CL_FOR_MONTH_5"];
         $collection_list_data[$i]["CUS_MON_6"] = $collection_list_fetched[$i]["CL_FOR_MONTH_6"];
         $collection_list_data[$i]["CUS_MON_7"] = $collection_list_fetched[$i]["CL_FOR_MONTH_7"];
         $collection_list_data[$i]["CUS_MON_8"] = $collection_list_fetched[$i]["CL_FOR_MONTH_8"];
         $collection_list_data[$i]["CUS_MON_9"] = $collection_list_fetched[$i]["CL_FOR_MONTH_9"];
         $collection_list_data[$i]["CUS_MON_10"] = $collection_list_fetched[$i]["CL_FOR_MONTH_10"];
         $collection_list_data[$i]["CUS_MON_11"] = $collection_list_fetched[$i]["CL_FOR_MONTH_11"];
         $collection_list_data[$i]["CUS_MON_12"] = $collection_list_fetched[$i]["CL_FOR_MONTH_12"];
         // $collection_list_data[$i]["BAL_DUE_MON"]=$collection_list_fetched[$i]["CL_BALANCE_DUE_MONTH"];

      }
      for ($j = 0; $j < count($collection_list_data); $j++) {

         $final_list[$j] = $collection_list_data[$j];
      }

      return $final_list;
   }

   public function pay_due($cus_id, $amount_paid, $pay_by)
   {

      $sql = "SELECT * FROM ".$this->table_name." WHERE `COL_FOR_CUS_ID`=".$cus_id." AND `COL_DUE_BALANCE` != 0" ;
      $stmt = $this->conn->prepare($sql);

      if ($stmt->execute()) {

         $collect_data = $stmt->fetchall(PDO::FETCH_ASSOC);
         if(count($collect_data)>0)
         {
            $check_bal = $collect_data[0]['COL_DUE_BALANCE'];

            if($check_bal < $amount_paid ){ // Checking Existing Loan Amount
               return false;
            }
            // Updating Due Amount
            $payAmount = $collect_data[0]['COL_DUE_BALANCE'] - $amount_paid;
            $sql="UPDATE `collection_master` SET `COL_DUE_BALANCE`=".$payAmount." WHERE `COL_FOR_CUS_ID`=".$cus_id;
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute()) {
               // Updating Transction
               $sql="INSERT INTO `transaction_master`(`TR_OF_CUS`,`TR_DONE_TO`, `TR_PAID_AMOUNT`)
               VALUES (".$cus_id.",".$pay_by.",".$amount_paid.")";
               $stmt = $this->conn->prepare($sql);

               if ($stmt->execute()) {
                  return true;
               }
            }
         }
         else{
            return false;
         }

      }
   }

}