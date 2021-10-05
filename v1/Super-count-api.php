<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/customer.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$customer_obj = new Customer($connection);
$util=new Util();


if($_SERVER['REQUEST_METHOD'] === "GET"){

   $data = json_decode(file_get_contents("php://input"));
    
    $plan_data=$customer_obj->super_count_by_plan();
    $place_data=$customer_obj->super_count_by_place();
    $agent_data=$customer_obj->super_count_by_agent();

       
     if($util::validate_is_empty($plan_data) || $util::validate_is_empty($place_data) || $util::validate_is_empty($agent_data))
     {
        http_response_code(200);
        echo json_encode(["status"=>"1","plan"=>$plan_data,"place"=>$place_data,"agent"=>$agent_data]);
     }
     else
     {
        http_response_code(200);
        echo json_encode(["status"=>"1","data"=>"Count is Empty"]);
     }
  
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Get Method"]);
}