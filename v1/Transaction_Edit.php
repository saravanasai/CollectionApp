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

    $trans_edit=$trans_obj->transaction_edit($data->TR_ID,$data->CUS_ID,$data->TRANS_AMOUNT);

    if($trans_edit){
      http_response_code(200);
      echo json_encode(["status"=>"1","data"=>"Transactions is Updated"]);
    }else{
      http_response_code(500);
      echo json_encode(["status"=>"1","data"=>"Update Error"]);
    }

 }
 else
 {
     http_response_code(403);
     echo json_encode(["status"=>"0","data"=>"This Api Supports Only Post Methode"]);
 }