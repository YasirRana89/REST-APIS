<?php

class Comments{

 

    // database connection and table name

    private $conn;

    private $table_name = "comments";

 

    // object properties

    public $post_id;

    public $commenter_full_name;

    public $email;

    public $comment;

    public $created_at;

    public $updated_at;

    public $created_by;

    public $updated_by;

    public $status;

 

 

    // constructor with $db as database connection

    public function __construct($db){

        $this->conn = new Database();

        $this->conn = $this->conn->getmyDB();

    }



   function createCommentList(){
        $query = "INSERT INTO
        " . $this->table_name . "
     SET
     comment_id=:comment_id,post_id=:post_id,commenter_full_name=:commenter_full_name,email=:email,comment=:comment,created_at=:created_at, updated_at=:updated_at,created_by=:created_by,
     updated_by=:updated_by,status=:status";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize

        // $this->comment_id=htmlspecialchars(strip_tags($_POST['comment_id']));
        $this->post_id=htmlspecialchars(strip_tags($_POST['post_id']));
        $this->commenter_full_name=htmlspecialchars(strip_tags($_POST['commenter_full_name']));
        $this->comment=htmlspecialchars(strip_tags($_POST['comment']));
        $this->email=htmlspecialchars(strip_tags($_POST['email']));
        // die($this->first_name);
        // die($this->last_name);
        $this->created_at=htmlspecialchars(strip_tags($_POST['created_at']));
        $this->updated_at=htmlspecialchars(strip_tags($_POST['updated_at']));
        $this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));
        $this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));
        $this->status=htmlspecialchars(strip_tags($_POST['status']));
        // bind values
        $stmt->bindParam(":comment_id", $this->comment_id);
        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->bindParam(":commenter_full_name", $this->commenter_full_name);
        $stmt->bindParam(":comment", $this->comment);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":created_by", $this->created_by);
        $stmt->bindParam(":updated_by", $this->updated_by);
        $stmt->bindParam(":status", $this->status);
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    return false;
}

    function deleteCommentList(){

        

    $query = "DELETE FROM " . $this->table_name . " WHERE comment_id = ?";



    $stmt = $this->conn->prepare($query);

 

    // sanitize

    $this->comment_id=htmlspecialchars(strip_tags($_POST['comment_id']));

 

    // bind id of record to delete

    $stmt->bindParam(1, $this->comment_id);

 

    // execute query

    if($stmt->execute()){

        return true;

    }

 

    return false;

    }



    function updateCommentList(){

       



        $query = "UPDATE

    " . $this->table_name . "

SET

  comment_id = :comment_id,

  post=:post-id,

  commenter_full_name = :commenter_full_name,

  email = :email,

  comment = :comment,

  created_at = :created_at,

  updated_at = :updated_at,

  created_by = :created_by,

  updated_by = :updated_by,

  status = :status,

WHERE

    comment_id = :comment_id

    post_id=:post_id ";

 



    



// prepare query statement

$stmt = $this->conn->prepare($query);



// sanitize

// $this->comment_id=htmlspecialchars(strip_tags($_UPDATE['comment_id']));

$this->post_id=htmlspecialchars(strip_tags($_POST['post_id']));

$this->commenter_full_name=htmlspecialchars(strip_tags($_POST['commenter_full_name']));

$this->email=htmlspecialchars(strip_tags($_POST['email']));

$this->comment=htmlspecialchars(strip_tags($_POST['comment']));

$this->created_at=htmlspecialchars(strip_tags($_POST['created_at']));

$this->updated_at=htmlspecialchars(strip_tags($_POST['updated_at']));

$this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));

$this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));

$this->status=htmlspecialchars(strip_tags($_POST['status']));



// bind new values

// $stmt->bindParam(":comment_id", $this->comment_id);

$stmt->bindParam(":post_id", $this->post_id);

$stmt->bindParam(":commenter_full_name", $this->commenter_full_name);

$stmt->bindParam(":email", $this->email);

$stmt->bindParam(":comment", $this->comment);

$stmt->bindParam(":created_at", $this->created_at);

$stmt->bindParam(":updated_at", $this->updated_at);

$stmt->bindParam(":created_by", $this->created_by);

$stmt->bindParam(":updated_by", $this->updated_by);

$stmt->bindParam(":status", $this->status);



// execute the query

if($stmt->execute()){

return true;

}



return false;

   }

   function getCommentList(){

    

       

        // select categories SQL

        $query = "SELECT * FROM {$this->table_name} WHERE status = :status";

        

        $where = [

            'status' => true

        ];

        // prepare query

        $stmt = $this->conn->prepare($query); 

         // sanitize

        //  $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        //  $this->first_name=htmlspecialchars(strip_tags($this->first_name));

        //  $this->last_name=htmlspecialchars(strip_tags($this->last_name));

        //  $this->username=htmlspecialchars(strip_tags($this->username));

        //  $this->password=htmlspecialchars(strip_tags($this->password));

        //  $this->email=htmlspecialchars(strip_tags($this->email));

        //  $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        //  $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));

        //  $this->created_by=htmlspecialchars(strip_tags($this->created_by));

        //  $this->updated_by=htmlspecialchars(strip_tags($this->updated_by));

        //  $this->status=htmlspecialchars(strip_tags($status));

        // bind values

        //  $stmt->bindParam(":user_id", $this->user_id);

        //  $stmt->bindParam(":first_name", $this->first_name);

        //  $stmt->bindParam(":last_name", $this->last_name);

        // $stmt->bindParam(":username", $this->username);

        //  $stmt->bindParam(":password", $this->password);

        // $stmt->bindParam(":email", $this->email);

        // $stmt->bindParam(":created_at", $this->created_at);

        //  $stmt->bindParam(":updated_at", $this->updated_at);

        //  $stmt->bindParam(":created_by", $this->created_by);

        //  $stmt->bindParam(":updated_by", $this->updated_by);

         $stmt->bindParam(':status', $staus);   

         $staus = 1;

        // execute query

        $stmt->execute();

        //echo $stmt->debugDumpParams();die('Exit here');

        $totalRecords = $stmt->rowCount();

        $result=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $user_item=array(

                "user_id" => $comment_id,

                "post_id"=> $post_id,

                "first_name" => $commenter_full_name,

                "last_name" => $comment,

                "created_at" => $created_at,

                "updated_at" => $updated_at,

                "created_by" => $created_by,

                "updated_by" => $updated_by,

                "status" => $status

            );    

            array_push($result, $user_item);

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



    





								

