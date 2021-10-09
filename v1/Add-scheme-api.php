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
     
    if($util->validate_is_empty($data->SCHEME_NAME) && $util->validate_is_empty($data->SCHEME_START_DATE) && $util->validate_is_empty(($data->SCHEME_END_DATE)))
    {
         $scheme_obj->scheme_name=$data->SCHEME_NAME;
         $scheme_obj->scheme_start_date=$data->SCHEME_START_DATE;
         $scheme_obj->scheme_end_date=$data->SCHEME_END_DATE;
         if($scheme_obj->register_scheme())
         {
            http_response_code(200);
            echo json_encode(["status" => "1", "data" => "INSERTED SUCCESSFULLY"]);
         } 
         else
         {
            http_response_code(500);
            echo json_encode(["status" => "1", "data" => "SOMETHINGS WENT WRONG"]);
         }
    }
    else
    {
        http_response_code(200);
        echo json_encode(["status" => "0", "data" => "FILL ALL THE FEILDS"]);
    }
    
  
}
else {
    
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
    
  }