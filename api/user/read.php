<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: application/json");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

// include database and object files
include_once '../../config/database.php';
include_once '../../model/user.php';

// instantiate database and product object
$database = new database();
$db = $database->getConnection();

// initialize object
$user = new user($db);

$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
$user->password = $data->password;

// read products will be here
$result = $user->singleUser();
//$rowCount = $result->rowCount();

if (count($result) == 1){
    http_response_code(200);
    echo json_encode(array("data" => $result, "status" => 200));
}else if(count($result) == 2) {
    http_response_code(201);
    echo json_encode(array("data" => "Email or Password incorrect", "status" => 201));
}else{
    http_response_code(202);
    echo json_encode(array("message" => 'No user please register our system', "status" => 202));
}

