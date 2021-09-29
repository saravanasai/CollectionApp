<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/plan.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$plan_obj = new Plans($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
     
    if($util::validate_is_empty($data->plan_amount))
    {     
            $plan_obj->planeamount=$data->plan_amount;

            if($plan_obj->check_Plan_exist())
            { 
                    if($plan_obj->insert_plan()) 
                {
                    http_response_code(200);
                    echo json_encode(["status"=>"1","data"=>"New Plan Added"]);
                }
                else
                {
                    http_response_code(500);
                    echo json_encode(["status"=>"0","data"=>"Something went Wrong"]);
                }

            }
            else
            {
                http_response_code(200);
                echo json_encode(["status"=>"0","data"=>"Plan Already Exist"]);
            }
            
    }
    else
    {
        http_response_code(200);
        echo json_encode(["status"=>"0","data"=>"Plan Amount Feild is Empty"]);
    }
  
  
}
else {
    
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
    
  }