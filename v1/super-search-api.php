<?php
ini_set("display_errors", 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/customer.php");

//objects
$db = new Database();

$connection = $db->Connect();

$customer_obj = new Customer($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
  $data = json_decode(file_get_contents("php://input"));
  
  $res_data = $customer_obj->searchCustomer($data->search);
  
  $response_data=array();
  
   foreach($res_data as $key=>$customer)
   {
       $response_data[$key]=$customer;
   }
   echo json_encode(["status"=>"1","data"=>$response_data]);
  }
else {
    
  http_response_code(403);
  echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
  
}
