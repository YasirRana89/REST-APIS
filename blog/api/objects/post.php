<?php
class BlogPost
{
 
    // database connection and table name
    private $conn;
    private $table_name = "posts";
 
    // object properties
    public $category_id;
    public $post_id;
    public $username;
    public $user_id;
    public $url;
    public $caption;
    public $post_title;
    public $post_description;   
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $status;
    public $email;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = new Database();
        $this->conn = $this->conn->getmyDB();
    }


    function generateImage($img){

        $folderPath = "/home/muirislamfass/public_html/apps/blog/uploads/images/";
        $image_parts = str_replace('data:image/png;base64,', '', $img);
        
        $img = str_replace(' ', '+', $img);
        $image_base64 = base64_decode($img);
        chmod($folderPath, 0777);
        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        chmod($folderPath, 0755);
        return [
            'path' => $file,
            'url' => 'http://mufassirislam.com/apps/blog/uploads/images/'.$fileName
        ];
    }


    function insertPost(){
        
        $image_name = $_POST['url'];
        $imagePaths = $this->generateImage($image_name);
        

        $query = "INSERT INTO
        " . $this->table_name . "
     SET
     category_id = :category_id,
     username = :username,
     url = :url,
     caption = :caption,
     post_id = :post_id, 
     user_id = :user_id, 
     post_title = :post_title, 
     post_description = :post_description, 
     created_at = :created_at, 
     updated_at = :updated_at,
     created_by = :created_by,
     updated_by = :updated_by, 
     email = :email;";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        $this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        $this->category_id=htmlspecialchars(strip_tags($_POST['category_id']));
        $this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        $this->username=htmlspecialchars(strip_tags($_POST['username']));
        $this->url = $imagePaths['url'];
        
        

        $this->caption=htmlspecialchars(strip_tags($_POST['caption']));
        // die($this->first_name);
        // die($this->last_name);
        $this->post_title=htmlspecialchars(strip_tags($_POST['post_title']));
        $this->post_description=htmlspecialchars(strip_tags($_POST['post_description']));
        $this->created_at = date('Y-m-d h:i');
        $this->updated_at = date('Y-m-d h:i');
        $this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));
        $this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));
        //$this->status=htmlspecialchars(strip_tags($_POST['status']));
        $this->email=htmlspecialchars(strip_tags($_POST['email']));
        // bind values
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":caption", $this->caption);
        $stmt->bindParam(":post_title", $this->post_title);
        $stmt->bindParam(":post_description", $this->post_description);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":created_by", $this->created_by);
        $stmt->bindParam(":updated_by", $this->updated_by);
        //$stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":email", $this->email);

        $queryStatus = $stmt->execute();
        //echo $stmt->debugDumpParams();die('Exit here');
        // execute query
        $response = [];
        $response['status'] =  false;
        if($queryStatus){             
            //$this->id = $this->conn->lastInsertId();
            $response['status'] =  true;
        }        
        echo json_encode($response); exit;
}

function getPostListById(){
    

    // select categories SQL
//    $query = "SELECT * FROM {$this->table_name} WHERE status = :status";
    $query = " SELECT category.category_id,category.category_name,
                        posts.post_id,posts.user_id,posts.username,posts.caption,posts.created_at,posts.updated_at, posts.url, posts.post_title, posts.post_description, 
                        posts.email, posts.status as status
                FROM  {$this->table_name}
                LEFT JOIN category 
                    ON (category.category_id=posts.category_id)
                    WHERE  find_in_set(:category_id,posts.category_id) AND posts.status=:status";
        
        $category_id = $_GET['category_id'];
        $where = ['status'=>true];
        if($category_id)
            $where['category_id']=$category_id;

      // prepare query
        $stmt = $this->conn->prepare($query);
        //$stmt->bindParam(':status', $status);   
        $status = 1;  
        // execute query
        $stmt->execute($where);
       // echo $stmt->debugDumpParams();die('Exit here');
       $totalRecords = $stmt->rowCount();
       $result=array();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       extract($row);
    //    $ImageUrl = 'http://mufassirislam.com/apps/blog'.$url;
       $posts_item=array(
        "category_id" => $category_id,
        "post_id" => $post_id,
        "username" => $username,
        "url" => $url,
        "caption" => $caption,
        "user_id" => $user_id,
        "post_title" => $post_title,
        "post_description" => html_entity_decode($post_description),
        "created_at" => $created_at,
        "updated_at" => $updated_at,
        "created_by" => $created_by,
        "updated_by" => $updated_by,
        "category_name"=>$category_name,
         "email"=>$email,
        "status" => $status
    );    
    array_push($result, $posts_item);
}

// put consition if reconds exist
$response = [
    
    'totalreeconds' => $totalRecords, // total records found
    'result' => $result,// set of array
    'currentpage' => 1,
    'prevpage' => 0,
    'nextpage' => 2
];
return $response;

}








  function searchPostList(){
       // select categories SQL
       $query = "SELECT
       category.name as category_name,category.category_id, posts.user_id, posts.username,posts.url,posts.caption, posts.post_title, posts.post_description, posts.created_at,posts.updated_at,posts.created_by,posts.updated_by,posts.status
   FROM
       " . $this->table_name . " posts
       LEFT JOIN
           category category
               ON posts.category_id = category.category_id
   WHERE
   posts.post_title LIKE ? OR posts.post_description LIKE ? OR category.category.name LIKE ?
   ORDER BY
   posts.created DESC";
    // prepare query
    $stmt = $this->conn->prepare($query); 
       // sanitize
        // $this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        // $this->category_id=htmlspecialchars(strip_tags($_POST['category_id']));
        // $this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        // $this->username=htmlspecialchars(strip_tags($_POST['username']));
        // $this->url=htmlspecialchars(strip_tags($_POST['url']));
        // $this->caption=htmlspecialchars(strip_tags($_POST['caption']));




        // // die($this->first_name);
        // // die($this->last_name);
        // $this->post_title=htmlspecialchars(strip_tags($_POST['post_title']));
        // $this->post_description=htmlspecialchars(strip_tags($_POST['post_description']));
        // $this->created_at=htmlspecialchars(strip_tags($_POST['created_at']));
        // $this->updated_at=htmlspecialchars(strip_tags($_POST['updated_at']));
        // $this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));
        // $this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));
        // $this->status=htmlspecialchars(strip_tags($_POST['status']));
        // bind values
        // $stmt->bindParam(":category_id", $this->category_id);
        // $stmt->bindParam(":post_id", $this->post_id);
        // $stmt->bindParam(":user_id", $this->user_id);
        // $stmt->bindParam(":email", $this->email);
        // $stmt->bindParam(":url", $this->url);
        // $stmt->bindParam(":caption", $this->caption);
        // $stmt->bindParam(":post_title", $this->post_title);
        // $stmt->bindParam(":post_description", $this->post_description);
        // $stmt->bindParam(":created_at", $this->created_at);
        // $stmt->bindParam(":updated_at", $this->updated_at);
        // $stmt->bindParam(":created_by", $this->created_by);
        // $stmt->bindParam(":updated_by", $this->updated_by);
        // $stmt->bindParam(":status", $this->status);
        // $stmt->bindParam(":category_name", $this->category_name);
        $status = 1;  
        // execute query
        $stmt->execute();
       echo $stmt->debugDumpParams();die('Exit here');
        $totalRecords = $stmt->rowCount();
        $result=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $blog_post_item=array(
            "category_id" => $category_id,
            "post_id" => $post_id,
            "username" => $username,
            "url" => $url,
            "caption" => $caption,
            "user_id" => $user_id,
            "post_title" => $post_title,
            "post_description" => html_entity_decode($post_description),
            "created_at" => $created_at,
            "updated_at" => $updated_at,
            "created_by" => $created_by,
            "updated_by" => $updated_by,
            "category_name"=>$category_name,
            "status" => $status
     );    
     array_push($result, $blog_post_item);
 }

    // put consition if reconds exist
    $response = [
     
     'totalreeconds' => $totalRecords, // total records found
     'result' => $result,// set of array
     'currentpage' => 1,
     'prevpage' => 0,
     'nextpage' => 2
    ];
    return $response;

   }







   function deletePostList(){
      
    $query = "DELETE FROM " . $this->table_name . " WHERE Post_id = ?";

    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->post_id=htmlspecialchars(strip_tags($_POST['post_id']));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->post_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     

   }









   function updatePostList(){
       // update query
    $query = "UPDATE
    " . $this->table_name . "
SET
 category_id = :category_id,
 post_id = :post_id,
 username = :username,
 url = :url,
 caption = :caption,
 user_id = :user_id,
 post_title = :post_title,
 post_description = :post_description,
 post_id = :post_id,
 created_at = :created_at,
 updated_at = :updated_at,
 created_by = :created_by,
 updated_by = :updated_by,
 status = :status,
 category_name=:category_name
WHERE
    category_id = :category_id;
    post_id = :post_id;
    user_id = :user_id";
 

    

// prepare query statement
$stmt = $this->conn->prepare($query);


        // sanitize
        //$this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        $this->category_id=htmlspecialchars(strip_tags($_POST['category_id']));
        $this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        $this->username=htmlspecialchars(strip_tags($_POST['username']));
        $this->url=htmlspecialchars(strip_tags($_POST['url']));
        $this->caption=htmlspecialchars(strip_tags($_POST['caption']));




        // die($this->first_name);
        // die($this->last_name);
        $this->post_title=htmlspecialchars(strip_tags($_POST['post_title']));
        $this->post_description=htmlspecialchars(strip_tags($_POST['post_description']));
        $this->created_at=htmlspecialchars(strip_tags($_POST['created_at']));
        $this->updated_at=htmlspecialchars(strip_tags($_POST['updated_at']));
        $this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));
        $this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));
        $this->status=htmlspecialchars(strip_tags($_POST['status']));
        $this->category_name=htmlspecialchars(strip_tags($_POST['category_name']));
        // bind values
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":caption", $this->caption);
        $stmt->bindParam(":post_title", $this->post_title);
        $stmt->bindParam(":post_description", $this->post_description);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":created_by", $this->created_by);
        $stmt->bindParam(":updated_by", $this->updated_by);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":category_name", $this->category_name);



// execute the query
if($stmt->execute()){
return true;
}

return false;
   }





    //    read products with pagination
public function readPaging($from_record_num, $records_per_page){
   
    // select query
    $query = "SELECT
                p.category_id, p.category_name, p.user_id, p.user_id,p.post_title, c.created_at,c.updated_at,c.created_by,c.updated_by,c.status
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category
                        ON c.category_id = p.category_id
            ORDER BY p.created DESC
            LIMIT ?, ?";
            
           
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    
    
    
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
    echo $stmt->debugDumpParams($query);

    // return values from database
    return $stmt;
}
// used for paging products




public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

   function RandomPosts(){
    $query = "SELECT * FROM {$this->table_name} WHERE  status = :status";
    $where = [
        'status' => true,
    ];
       $stmt = $this->conn->prepare($query);



        //$this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
       //     $this->category_id=htmlspecialchars(strip_tags($_POST['category_id']));
       //     $this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
       //     $this->email=htmlspecialchars(strip_tags($_POST['email']));
       //     $this->url=htmlspecialchars(strip_tags($_POST['url']));
       //     $this->caption=htmlspecialchars(strip_tags($_POST['caption']));
   
   
   
   
       //     // die($this->first_name);
       //     // die($this->last_name);
       //     $this->post_title=htmlspecialchars(strip_tags($_POST['post_title']));
       //     $this->post_description=htmlspecialchars(strip_tags($_POST['post_description']));
       //     $this->created_at=htmlspecialchars(strip_tags($_POST['created_at']));
       //     $this->updated_at=htmlspecialchars(strip_tags($_POST['updated_at']));
       //     $this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));
       //     $this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));
       //     $this->status=htmlspecialchars(strip_tags($_POST['status']));
       //     $this->category_name=htmlspecialchars(strip_tags($_POST['category_name']));
       //     // bind values
       //     $stmt->bindParam(":category_id", $this->category_id);
        //    $stmt->bindParam(":post_id", $this->post_id);
       //     $stmt->bindParam(":user_id", $this->user_id);
       //     $stmt->bindParam(":email", $this->email);
       //     $stmt->bindParam(":url", $this->url);
       //     $stmt->bindParam(":caption", $this->caption);
       //     $stmt->bindParam(":post_title", $this->post_title);
       //     $stmt->bindParam(":post_description", $this->post_description);
       //     $stmt->bindParam(":created_at", $this->created_at);
       //     $stmt->bindParam(":updated_at", $this->updated_at);
       //     $stmt->bindParam(":created_by", $this->created_by);
       //     $stmt->bindParam(":updated_by", $this->updated_by);
       //     $stmt->bindParam(":status", $this->status);
       //     $stmt->bindParam(":category_name", $this->category_name);
   
        //    $stmt->bindParam(':status', $status);   
           $status = 1;  
           // execute query
           $stmt->execute($where);
           //echo $stmt->debugDumpParams();die('Exit here');
          $totalRecords = $stmt->rowCount();
          $result=array();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $posts_item=array(
           "category_id" => $category_id,
           "post_id" => $post_id,
           "username" => $username,
           "url" => $url,
           "caption" => $caption,
           "user_id" => $user_id,
           "post_title" => $post_title,
           "post_description" => html_entity_decode($post_description),
           "created_at" => $created_at,
           "updated_at" => $updated_at,
           "created_by" => $created_by,
           "updated_by" => $updated_by,
           "category_name"=>$category_name,
           "status" => $status
       );    
       array_push($result, $posts_item);
   }
   
   // put consition if reconds exist
   $response = [
       
       'totalreeconds' => $totalRecords, // total records found
       'result' => $result,// set of array
       'currentpage' => 1,
       'prevpage' => 0,
       'nextpage' => 2
   ];
   return $response;
   
   }
   function SinglePostById(){
    

    // select categories SQL
   $query = "SELECT * FROM {$this->table_name} WHERE post_id=:post_id AND status=:status";
    // $query = " SELECT category.category_id,category.category_name,
    //                     posts.post_id,posts.user_id,posts.username, posts.url, posts.post_title, posts.post_description, 
    //                     posts.email, posts.status as status

    //     FROM  {$this->table_name}
    //     LEFT JOIN category 
    //         ON (category.category_id=posts.category_id)
            // WHERE posts.category_id =:category_id AND posts.status=:status";
        
        $post_id = $_GET['post_id'];
        $where = ['status'=>true];
        if($post_id)
            $where['post_id']=$post_id;

      // prepare query
        $stmt = $this->conn->prepare($query);
        //$stmt->bindParam(':status', $status);   
        $status = 1;  
        // execute query
        $stmt->execute($where);
       // echo $stmt->debugDumpParams();die('Exit here');
       $totalRecords = $stmt->rowCount();
       $result=array();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       extract($row);
       $posts_item=array(
        "category_id" => $category_id,
        "post_id" => $post_id,
        "username" => $username,
        "url" => $url,
        "caption" => $caption,
        "user_id" => $user_id,
        "post_title" => $post_title,
        "post_description" => html_entity_decode($post_description),
        "created_at" => $created_at,
        "updated_at" => $updated_at,
        "created_by" => $created_by,
        "updated_by" => $updated_by,
        "category_name"=>$category_name,
         "email"=>$email,
        "status" => $status
    );    
    array_push($result, $posts_item);
}

// put consition if reconds exist
$response = [
    
    'totalreeconds' => $totalRecords, // total records found
    'result' => $result,// set of array
    'currentpage' => 1,
    'prevpage' => 0,
    'nextpage' => 2
];
return $response;

}


}
?>