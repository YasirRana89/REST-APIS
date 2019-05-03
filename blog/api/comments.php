<?php
// include database and object files
include_once './config/db_connection.php';
include_once './objects/comments.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function createComment(){
    
    $conn = new Database();
    $comments = new Comments($conn);
    $response = $comments->createCommentList();
    http_response_code(200);
    die(json_encode($response));

}
function deleteComment(){
    
    $conn = new Database();
    $comments = new Comments($conn);
    $response = $comments->deleteCommentList();
    http_response_code(200);
    die(json_encode($response));
}
function updateComment(){
    
    $conn = new Database();
    $comments = new Comments($conn);
    $response = $comments->updateCommentList();
    http_response_code(200);
    die(json_encode($response));
}
function getComment(){
    
    $conn = new Database();
    $comments = new Comments($conn);
    $response = $comments->getCommentList();
    http_response_code(200);
    die(json_encode($response));
}
switch($_REQUEST['action']){

    case 'createCommentList';
    createComment();
    break;

    case 'deleteCommentList';
    deleteComment();
    break;

    case 'updateCommentList';
    updateComment();
    break;
    case 'getCommentList';
    getComment();
    break;
    default;
    echo 'Action does not exist';


}