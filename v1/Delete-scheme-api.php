<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/scheme.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$scheme_obj = new scheme($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
      
   if($util->validate_is_empty($data->scheme_id))
   {
           if($scheme_obj->delete_scheme($data->scheme_id))
           {
            http_response_code(200);
            echo json_encode(["status" => "1", "data" => "SCEHEME DELETED SUCCSFULLY"]);
           } 
           else
           {
            http_response_code(500);
            echo json_encode(["status" => "1", "data" => "SOMETHING WENT WRONG"]);
           }
   }
   else
   {
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "FILL SCHEME ID FEILD"]);
   }
    
}
else {
    
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
    
  }