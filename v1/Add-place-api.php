<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/place.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$place_obj = new Places($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
     
    if($util::validate_is_empty($data->place_name))
    {     
            $place_obj->placename=$data->place_name;

            if($place_obj->check_place_exist())
            { 
                    if($place_obj->insert_place()) 
                {
                    http_response_code(200);
                    echo json_encode(["status"=>"1","data"=>"Place Inserted"]);
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
                echo json_encode(["status"=>"0","data"=>"Place Already Exist"]);
            }
            
    }
    else
    {
        http_response_code(200);
        echo json_encode(["status"=>"0","data"=>"Place Name Feild is Empty"]);
    }
  
  
}
else {
    
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
    
  }