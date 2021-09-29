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
     
    if($util::validate_is_empty($data->agent_id))
    {
        if($util::validate_isNumeric($data->agent_id))
        {
            $agent_obj->agent_id=$data->agent_id;
            if($agent_obj->delete_agent())
            {
                http_response_code(200);
                echo json_encode(["status" => "1", "data" => "DELETED AGENT SUCCESSFULLY"]);
            }
            else
            {
                http_response_code(200);
                echo json_encode(["status" => "0", "data" => "SOMETHING WENT WRONG"]);
            }

        }else
        {
            http_response_code(200);
            echo json_encode(["status" => "0", "data" => "AGENT ID MUST BE ONLY NUMERIC"]);
        }
    }
    else
    {
        http_response_code(200);
        echo json_encode(["status" => "0", "data" => "FILL THE AGENT ID"]);
    }
}
else {
    
    http_response_code(403);
    echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
    
  }