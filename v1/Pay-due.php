<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/customer.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$collection_obj = new collection_list($connection);
$util=new Util();


if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
    
   $collection_obj->by_admin=$data->BY_ADMIN;
   $pay=$collection_obj->pay_due($data->CUS_ID,$data->DUE_PAYED);
    
      if($pay)
      {
        http_response_code(200);
        echo json_encode(["status"=>"1","data"=>"Due paid"]);
      }
      else
      {
        http_response_code(500);
        echo json_encode(["status"=>"0","data"=>"Something went Wrong"]);
      }
      
       
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Post Methode"]);
}