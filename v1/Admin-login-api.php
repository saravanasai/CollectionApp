<?php
ini_set("display_errors", 1);


//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/admin.php");
include_once("../utility/utility.php");

//objects
$db = new Database();
$util = new Util();

$connection = $db->Connect();

$admin_obj = new Admin($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
    
    //checking values are not null
    if($util::validate_is_empty($data->password)&&$util::validate_is_empty($data->phonenumber))
    {
      if($util::validate_phonenumber_length($data->phonenumber))
      {
             if($admin_obj->check_user_exits($data->phonenumber))
             {
                  if($admin_obj->authenticate($data->phonenumber,$data->password))
                  {
                        $response=$admin_obj->get_admin_details($data->phonenumber);
                        http_response_code(200);
                        echo json_encode(["status"=>0,"data"=>$response]);
                  }
                  else
                  {
                    http_response_code(200);
                    echo json_encode(["status"=>0,"data"=>"PASSWORD DOES NOT MATCHS"]);
                  }
             }
             else
             {
              http_response_code(200);
              echo json_encode(["status"=>0,"data"=>"USER DOES NOT EXITS"]);
             }
      }
      else
      {
        http_response_code(200);
        echo json_encode(["status"=>0,"data"=>"PHONE NUMBER IS IN NOT CORRECT LENGTH"]);
      }
                       
    }
    else
    {
      http_response_code(200);
      echo json_encode(["status"=>0,"data"=>"ENTER ALL THE FEILD"]);
    }
  
}else {
    
  http_response_code(403);
  echo json_encode(["status" => "0", "data" => "This Api Supports Only Post Method"]);
  
}