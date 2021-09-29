<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/collectionmaster.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$collection_obj = new collection_list($connection);
$util=new Util();


if($_SERVER['REQUEST_METHOD'] === "GET"){

   $data = json_decode(file_get_contents("php://input"));
    
    $response_data=$collection_obj->all_collection_list();

       
     if($util::validate_is_empty($response_data))
     {
        http_response_code(200);
        echo json_encode(["status"=>"1","data"=>$response_data]);
     }
     else
     {
        http_response_code(200);
        echo json_encode(["status"=>"1","data"=>"Collection List is Empty"]);
     }
  
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Get Methode"]);
}