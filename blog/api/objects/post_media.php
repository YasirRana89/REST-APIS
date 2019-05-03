<?php
class Post_media{
 
    // database connection and table name
    private $conn;
    private $table_name = "Post_media";
 
    // object properties
    public $media_id;
    public $post_id;
    public $is_featured;
   
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

   function create_post_media_list(){
    $query = "INSERT INTO
    " . $this->blog_post . "
 SET
 media_id=:media_id, post_id=:post_id, is_featured=:is_featured, comment=:comment,";
    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize
    // $this->media_id=htmlspecialchars(strip_tags($_POST['media_id']));
    $this->post_id=htmlspecialchars(strip_tags($_POST['post_id']));
    $this->is_featured=htmlspecialchars(strip_tags($_POST['is_featured']));
   
    // bind values
    // $stmt->bindParam(":media_id", $this->media_id);
    $stmt->bindParam(":post_id", $this->post_id);
    $stmt->bindParam(":is_featured", $this->is_featured);
    
    // execute query
    if($stmt->execute()){
        return true;
    }
return false;


    }
    function get_post_media_list(){

    }
}

		