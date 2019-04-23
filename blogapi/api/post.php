<?php
// include database and object files
include_once './config/db_connection.php';
include_once './objects/post.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: GET");
//header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function createPost(){

    
    $conn = new Database();
    $blogpost = new BlogPost($conn);
    $response = $blogpost->insertPost();
    http_response_code(200);
    die(json_encode($response));

}
function getPost(){
    
    $conn = new Database();
    $blogpost = new Blogpost($conn);
    $response = $blogpost->getPostListById();
    http_response_code(200);
    die(json_encode($response));
}
function searchPost(){
    
    $conn = new Database();
    $blogpost = new Blogpost($conn);
    $response = $blogpost->searchPostList();
    http_response_code(200);
    die(json_encode($response));
}
function deletePost(){
    
    $conn = new Database();
    $blogpost = new Blogpost($conn);
    $response = $blogpost-> deletePostList();
    http_response_code(200);
    die(json_encode($response));}

function updatePost(){
    
    $conn = new Database();
    $blogpost = new Blogpost($conn);
    $response = $blogpost->updatePostList();
    http_response_code(200);
    die(json_encode($response));
}
function RandomPostsList(){
    
    $conn = new Database();
    $blogpost = new Blogpost($conn);
    $response = $blogpost->RandomPosts();
    http_response_code(200);
    die(json_encode($response));
}
function SinglePost(){
    
    $conn = new Database();
    $blogpost = new Blogpost($conn);
    $response = $blogpost->SinglePostById();
    http_response_code(200);
    die(json_encode($response));
}

// echo dirname(__FILE__);

switch($_REQUEST['action']){

    case 'insertPost';
        createPost();
    break;

    case 'getPostListById';
       getPost();
    break;

    case 'searchPostList';
       searchPost();
    break;

    case 'deletePostList';
     deletePost();
    break;

    case 'updatePostList';
     updatePost();
    break;

    case 'RandomPosts';
    RandomPostsList();
    break;

    case 'SinglePostById';
    SinglePost();
    break;

    default;
    echo 'Action does not exist';


}
