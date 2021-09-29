<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/place.php");


//objects
$db = new Database();

$connection = $db->Connect();

$place_obj = new Places($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

   $data = json_decode(file_get_contents("php://input"));
    
       $data=$place_obj->get_all_place();
       $response_data=array();
       foreach($data as $key=>$place)
       {
           $response_data[$key]=$place;
       }
       echo json_encode(["status"=>"1","data"=>$response_data]);
     
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Request Only Support GET Method"]);
}