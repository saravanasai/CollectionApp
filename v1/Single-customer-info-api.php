<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/customer.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$customer_obj = new Customer($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "GET"){

   $data = (isset($_GET['id']))?intval($_GET['id']):"";
    

    
        $customer_obj->cus_id=$data;
     
   
      if($customer_obj->check_customer_exist_by_cus_id())
      {
             $response=$customer_obj->get_single_customer();
             $response_data=array();
             foreach($response as $key=>$customer)
             {
                 $response_data[$key]=$customer;
             }
             echo json_encode(["status"=>"1","data"=>$response_data]);
      }
      else
      {
        http_response_code(200);
        echo json_encode(["status"=>"0","data"=>"User ID Does Not Matchs"]);
      }
   
  
  
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Get Methode"]);
}