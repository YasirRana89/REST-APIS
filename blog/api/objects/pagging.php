<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/db_connection.php';
include_once '../objects/post.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getmyDB();
 
// initialize object
$blogpost = new Blogpost($db);
 
// query products
$stmt = $blogpost->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $blogpost_arr=array();
    $blogpost_arr["records"]=array();
    $blogpost_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $blogpost=array(
        "category_id" => $category_id,
        "category_name"=> $category_id,
        "post_id" => $post_id,
        "user_id" => $user_id,
        "post_title" => $post_title,
        "post_description" => html_entity_decode($post_description),
        "created_at" => $created_at,
        "updated_at" => $updated_at,
        "created_by" => $created_by,
        "updated_by" => $updated_by,
        "status" => $status
        );
 
        array_push($blogpost_arr["records"], $blogpost_item);
    }
 
 
    // include paging
    $total_rows=$blogpost->count();
    $page_url="{$home_url}objects/paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $blogpost_arr["paging"]=$paging;
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($blogpost_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user products does not exist
    echo json_encode(
        array("message" => "No Posts found.")
    );
}
?>