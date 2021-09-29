<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/agent.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$agent_obj = new Agents($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
     
    if($util::validate_is_empty($data->agent_name))
    {     
            $agent_obj->agentname=$data->agent_name;
            $agent_obj->agentPhoneNumber=$data->agent_ph_no;
            $agent_obj->agentLocation=$data->agent_location;

            if($agent_obj->check_agent_exist())
            { 
                    if($agent_obj->insert_agent()) 
                {
                    http_response_code(200);
                    echo json_encode(["status"=>"1","data"=>"New Agent Added"]);
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
                echo json_encode(["status"=>"0","data"=>"Agent Already Exist"]);
            }
            
    }
    else
    {
        http_response_code(200);
        echo json_encode(["status"=>"0","data"=>"Agent Name Feild is Empty"]);
    }
  
  
}
else {
    
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
    
  }