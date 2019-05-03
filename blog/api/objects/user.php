<?php

class User{

 

    // database connection and table name

    private $conn;

    private $table_name = "user";

 

    // object properties

    public $user_id;
    public $first_name;
    public $last_name;
    public $username;
    public $password;
    public $email;
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

    function createUserList(){
      
      
        $query = "INSERT INTO

        " . $this->table_name . "
                SET
                user_id=:user_id, 
                first_name=:first_name, 
                last_name=:last_name,
                mobile=:mobile, 
                password=:password, 
                email=:email";

        
        $stmt = $this->conn->prepare($query);
        // print_r($query); exit;
       

        // sanitize

        //$this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));

        



        // die($this->first_name);

        // die($this->last_name);

        
        $this->first_name=htmlspecialchars(strip_tags($_POST['first_name']));
        $this->last_name=htmlspecialchars(strip_tags($_POST['last_name']));
        $this->password=md5(strip_tags($_POST['password']));
        $this->email=htmlspecialchars(strip_tags($_POST['email']));
        $this->mobile=htmlspecialchars(strip_tags($_POST['mobile']));
        // $this->created_at = date('Y-m-d h:i');
        // $this->updated_at = date('Y-m-d h:i');
        // $this->created_by =htmlspecialchars(strip_tags($_POST['created_by']));
        // $this->updated_by =htmlspecialchars(strip_tags($_POST['updated_by']));
        // $this->status =htmlspecialchars(strip_tags($_POST['status']));

        // bind values

       


        if(!$this->email && !$this->mobile && !$this->password){
            echo json_encode(['status' => false, 'msg'=>'Email, mobile and password are required fields', 'data'=> $_POST]); exit;
        }
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile", $this->mobile);
        // $stmt->bindParam(":created_at", $this->created_at);
        // $stmt->bindParam(":updated_at", $this->updated_at);
        // $stmt->bindParam(":created_by", $this->created_by);
        // $stmt->bindParam(":updated_by", $this->updated_by);
        // $stmt->bindParam(":status", $this->status);

        //echo $stmt->debugDumpParams();die('Exit here');
        // execute query
        $queryStatus = $stmt->execute();
        var_dump($queryStatus);
        if($queryStatus){
            echo json_encode(['status' => true, 'msg'=>'User created Successfully', 'data'=> $_POST]); exit;

        }

        echo json_encode(['status' => false, 'msg'=>'Filed to create a user ', 'data'=> $_POST]); exit;


}




function getUserList(){

        // select categories SQL

       
        $query = "SELECT
         *
    FROM
        {$this->table_name } 
    WHERE
        email=:email AND password=:password";
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        if($email && $password)
        $where['email']=$email;
        $where['password']=$password;
        // prepare query

        $stmt = $this->conn->prepare($query); 

        $stmt->execute($where);

        // echo $stmt->debugDumpParams();die('Exit here');


        if($stmt->rowCount() > 0){
            // get retrieved row
        $stmt->fetch(PDO::FETCH_ASSOC);
            // create array
         echo 'true';
        }
        else{
         echo 'false';
        }
        // make it json format
    


}}
