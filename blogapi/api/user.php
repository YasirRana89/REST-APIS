<?php
// include database and object files
include_once './config/db_connection.php';
include_once './objects/user.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: REQUEST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function createUser(){
    
    $conn = new Database();
    $user = new User($conn);
    $response = $user->createUserList();
    http_response_code(200);
    die(json_encode($response));

}
function getUser(){
    
    $conn = new Database();
    $user = new User($conn);
    $response = $user->getUserList();
    
    http_response_code(200);
    die(json_encode($response));
}

switch($_REQUEST['action']){

    case 'createUserList';
        createUser();
    break;

    case 'getUserList';
       getUser();
    break;
    default;
    echo 'Action does not exist';

}