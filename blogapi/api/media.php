<?php
// include database and object files
include_once './config/db_connection.php';
include_once './objects/media.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: REQUEST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function createMedia(){
    
    $conn = new Database();
    $user = new User($conn);
    $response = $user->postMediaList();
    http_response_code(200);
    die(json_encode($response));

}