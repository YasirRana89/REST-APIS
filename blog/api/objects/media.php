<?php
class Media{
 
    // database connection and table name
    private $conn;
    private $table_name = "media";
 
    // object properties
    public $media_id;
    public $url;
    public $user_id;
    public $caption;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $status;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function Post_media_list(){
        $query = "INSERT INTO
    " . $this->blog_post . "
 SET
 media_id=:media_id, url=:url,user_id=:user_id; caption=:caption,created_at=:created_at,updated_at=:updated_at,created_by=:created_by,
 updated_by=:updated_by, status=:status";
    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize
    // $this->media_id=htmlspecialchars(strip_tags($_POST['media_id']));
    $this->post_id=htmlspecialchars(strip_tags($_POST['url']));
    $this->post_id=htmlspecialchars(strip_tags($_POST['user_id']));
    $this->is_featured=htmlspecialchars(strip_tags($_POST['caption']));
    $this->created_at=htmlspecialchars(strip_tags($_UPDATE['created_at']));
    $this->updated_at=htmlspecialchars(strip_tags($_UPDATE['updated_at']));
    $this->created_by=htmlspecialchars(strip_tags($_UPDATE['created_by']));
    $this->updated_by=htmlspecialchars(strip_tags($_UPDATE['updated_by']));
    $this->status=htmlspecialchars(strip_tags($_UPDATE['status']));
   
    // bind values
    // $stmt->bindParam(":media_id", $this->media_id);
    $stmt->bindParam(":url", $this->url);
    $stmt->bindParam(":url", $this->user_id);
    $stmt->bindParam(":caption", $this->caption);
    $stmt->bindParam(":created_at", $this->created_at);
    $stmt->bindParam(":updated_at", $this->updated_at);
    $stmt->bindParam(":created_by", $this->created_by);
    $stmt->bindParam(":updated_by", $this->updated_by);
    $stmt->bindParam(":status", $this->status);
    
    // execute query
    if($stmt->execute()){
        return true;
    }
return false;
    }
}

							 