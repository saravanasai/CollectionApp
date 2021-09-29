<?php
ini_set("display_errors", 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/customer.php");
include_once("../utility/utility.php");

//objects
$db = new Database();
$connection = $db->Connect();
$customer_obj = new Customer($connection);
$util = new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));
      

      //validation for customer id is null or not
        if($util->validate_is_empty($data->cus_id)){
            $customer_obj->cus_id=$data->cus_id;

    if($customer_obj->check_customer_exist_by_cus_id())
    {
        if($util->validate_is_empty($data->cus_com_one) || $util->validate_is_empty($data->cus_com_two))
            {
                 if($customer_obj->update_complement($data->cus_com_one,$data->cus_com_two))
                 {
                    http_response_code(200);
                    echo json_encode(["status"=>"1","data"=>"Complement For User Updated"]);
                 }
                 else
                 {
                    http_response_code(500);
                    echo json_encode(["status"=>"0","data"=>"Something Went Wrong"]);
                 }
            }
            else
            {
                http_response_code(200);
                echo json_encode(["status"=>"0","data"=>"Feilds Should Not be Empty:- 1 for yes 0 for no"]);
            }
    }
    else
    {
        http_response_code(403);
        echo json_encode(["status"=>"0","data"=>"Customer Does Not Exist"]);
    }
        }
        else{
            http_response_code(200);
            echo json_encode(["status"=>"0","data"=>"Customer ID Should Not Be Null"]);
        }
      //end validation for customer id is null or not
    
}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only Post Methode"]);
}