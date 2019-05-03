<?php
// include database and object files
include_once './config/db_connection.php';
include_once './objects/create_post_media.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


function create_media_Post(){
    $conn = new Database();
    $postmedia = new PostMedia($conn);
    $response = $postmedia-> create_media_Post_list();
    http_response_code(200);
    die(json_encode($response));
}
