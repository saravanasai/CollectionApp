<?php
ini_set("display_errors", 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/customer.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$customer_obj = new Customer($connection);
$util=new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

    $data = json_decode(file_get_contents("php://input"));
    $from_date=$data->fromdate;
    $to_date=$data->todate;

      //validating the feilds or not null
      if($util->validate_is_empty($from_date))
      {
            if($util->validate_is_empty($to_date))
            {
                $reponse=$customer_obj->super_transaction($from_date,$to_date);
                http_response_code(200);
                echo json_encode(["status"=>"1","data"=>$reponse]);
            }
            else
            {
                http_response_code(200);
                echo json_encode(["status"=>"0","data"=>"To Date is Empty"]);
            }
      }
      else
      {
        http_response_code(200);
        echo json_encode(["status"=>"0","data"=>"From Date is Empty"]);

      }




}
else
{
    http_response_code(403);
    echo json_encode(["status"=>"0","data"=>"This Api Supports Only POST Methode"]);
}