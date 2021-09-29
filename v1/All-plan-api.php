<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/plan.php");


//objects
$db = new Database();

$connection = $db->Connect();

$plan_obj = new Plans($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

   $data = json_decode(file_get_contents("php://input"));
    
       $data=$plan_obj->get_all_plan();
       $response_data=array();
       foreach($data as $key=>$plan)
       {
           $response_data[$key]=$plan;
       }
       echo json_encode(["status"=>"1","data"=>$response_data]);
     
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Request Only Support GET Method"]);
}