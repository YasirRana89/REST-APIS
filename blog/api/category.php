<?php

// include database and object files

include_once './config/db_connection.php';

include_once './objects/category.php';







// required headers

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");



 

function getCategory(){

    

    $conn = new Database();

    $category = new Category($conn);

    $response = $category->getCategoryList();

    http_response_code(200);

    die(json_encode($response));

}



function searchCategory(){

    $conn = new Database();

    $category = new Category($conn);

    $response = $category->searchCategoryList();

    http_response_code(200);

    die(json_encode($response));

}

   function readPagging(){

    $conn = new Database();

    $category = new Category($conn);

    $response = $category->readPagingList();

    http_response_code(200);

    die(json_encode($response));

}

function getCategoryById(){

    $conn = new Database();

    $category = new Category($conn);

    $response = $category->getSingleCategory();

    http_response_code(200);

    die(json_encode($response));

}






switch($_REQUEST['action']){

    case 'getCategoryList';

        getCategory();

    break;



    case 'searchCategoryList';

    searchCategory();

    break;

    case 'readPagingList';

    readPagging();

    break;

    case 'getSingleCategory';

    getCategoryById();

    break;

    default;

    

    echo 'Action does not exist';

}



