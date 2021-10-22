<?php
ini_set("display_errors", 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../model/transaction.php");
include_once("../utility/utility.php");

//objects
$db = new Database();

$connection = $db->Connect();

$trans_obj = new transaction_list($connection);

$util=new Util();

if($_SERVER['REQUEST_METHOD'] === "POST"){

    $data = json_decode(file_get_contents("php://input"));

    $trans_today=$trans_obj->transaction_today($data->CUS_ID);

    $response_data=array();

       foreach($trans_today as $key=>$TR_ID)
       {
           $response_data[$key]=$TR_ID;
       }
       echo json_encode(["status"=>"1","data"=>$response_data]);
 }
 else
 {
     http_response_code(403);
     echo json_encode(["status"=>"0","data"=>"This Api Supports Only Post Methode"]);
 }