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
     user_id=:user_id, first_name=:first_name, last_name=:last_name,username=:username, password=:password, 
     email=:email, created_at=:created_at, updated_at=:updated_at,created_by=:created_by,
     updated_by=:updated_by, status=:status,";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        //$this->user_id=htmlspecialchars(strip_tags($_POST['user_id']));
        $this->first_name=htmlspecialchars(strip_tags($_POST['first_name']));
        $this->last_name=htmlspecialchars(strip_tags($_POST['last_name']));

        // die($this->first_name);
        // die($this->last_name);

        $this->password=htmlspecialchars(strip_tags($_POST['username']));
        $this->email=htmlspecialchars(strip_tags($_POST['password']));
        $this->email=htmlspecialchars(strip_tags($_POST['email']));
        $this->created_at=htmlspecialchars(strip_tags($_POST['created_at']));
        $this->updated_at=htmlspecialchars(strip_tags($_POST['updated_at']));
        $this->created_by=htmlspecialchars(strip_tags($_POST['created_by']));
        $this->updated_by=htmlspecialchars(strip_tags($_POST['updated_by']));
        $this->status=htmlspecialchars(strip_tags($_POST['status']));
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":password", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
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


function getUserList(){
        

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
                "user_id" => $user_id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "username" => $username,
                "password" => $password,
                "email" => $email,
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
