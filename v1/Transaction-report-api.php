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


if($_SERVER['REQUEST_METHOD'] === "GET"){

   $data = json_decode(file_get_contents("php://input"));
   
    $reponse=$customer_obj->super_transaction();
    http_response_code(200);
    echo json_encode(["status"=>"1","data"=>$reponse]);
  
  
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Get Methode"]);
}