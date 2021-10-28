<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/Due.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$Due_obj = new Due($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));

  if($util->validate_is_empty($data->PLAN_ID)&&$util->validate_is_empty($data->AMOUNT_LESS_THAN))
  {
        if($util->validate_isNumeric($data->PLAN_ID)&&$util->validate_isNumeric($data->AMOUNT_LESS_THAN))
        {
            $Due_obj->selected_plan_id=$data->PLAN_ID;
            $Due_obj->less_than_amount=$data->AMOUNT_LESS_THAN;
            $response=$Due_obj->get_balance_due_list();
            http_response_code(200);
            echo json_encode(["status"=>"1","data"=>$response]);
        }
        else
        {
            http_response_code(200);
            echo json_encode(["status"=>"0","data"=>"BOTH THE FEILD SHOULD BE NUMERIC VALUE"]);
        }
  }
  else
  {
    http_response_code(200);
    echo json_encode(["status"=>"0","data"=>"ENTER BOTH THE FEILD"]);
  }
  


}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Post Methode"]);
}