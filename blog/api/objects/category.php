<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "category";
 
    // object properties
    public $category_id;
    public $category_name;
    public $tags;
    public $category_description;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $thumb;
    public $updated_by;
    public $status;
    public $limit = 10;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = new Database();
        $this->conn = $this->conn->getmyDB();
        //$this->conn = $db;
    }
    
    function getCategoryList(){
    
        // select categories SQL
        $query = "SELECT * FROM {$this->table_name} WHERE  status = :status";
        // $query = " SELECT category.category_id,category.category_name,
        //                 posts.post_id,posts.user_id,posts.username, posts.url, posts.post_title, posts.post_description, 
        //                 posts.email, posts.status as status

        // FROM  {$this->table_name}
        // LEFT JOIN posts 
        //     ON (category.category_id=posts.category_id)
        //     WHERE category.category_id =:category_id
        //     AND posts.status =:status";
        
        $where = [
            'status' => true,
        ];
        // prepare query
        $stmt = $this->conn->prepare($query);  
       
        

        // execute query
        $stmt->execute($where);
        // echo $stmt->debugDumpParams();die('Exit here');
        $totalRecords = $stmt->rowCount();
        $result=array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $category_item=array(
                "category_id" => $category_id,
                "category_name" => $category_name,
                "tags" => $tags,
                "category_description" => html_entity_decode($category_description),
                "created_at" => $created_at,
                "thumb" => $thumb,
                "updated_at" => $updated_at,
                "created_by" => $created_by,
                "updated_by" => $updated_by,
                "status" => $status
            );    

            array_push($result, $category_item);
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


    function searchCategoryList(){
    // select categories SQL
    $query = "SELECT FROM . $this->table_name . WHERE status=:status";
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
    $stmt->bindParam(':status', $status);   
    $status = 1;  
    // execute query
    $stmt->execute();
    //echo $stmt->debugDumpParams();die('Exit here');
    $totalRecords = $stmt->rowCount();
    $result=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item=array(
            "category_id" => $category_id,
            "category_name" => $category_name,
            "tags" => $tags,
            "category_description" => html_entity_decode($category_description),
            "created_at" => $created_at,
            "updated_at" => $updated_at,
            "created_by" => $created_by,
             "thumb" => $thumb,
            "updated_by" => $updated_by,
            "status" => $status
        );    
        array_push($result, $category_item);
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




 
    function deletecategory(){

    }
    function getSingleCategory(){
        $query=$sql = "SELECT * 
        FROM  " . $this->table_name . "
        WHERE category_id =:category_id";
        $stmt = $this->conn->prepare( $query );
        
        $stmt->bindParam(':status', $status);   
        $status = 1;  
        // execute query
        $stmt->execute();
        $totalRecords = $stmt->rowCount();
    $result=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item=array(
            "category_id" => $category_id,
            "category_name" => $category_name,
            "tags" => $tags,
            "category_description" => html_entity_decode($category_description),
            "created_at" => $created_at,
            "updated_at" => $updated_at,
            "created_by" => $created_by,
             "thumb" => $thumb,
            "updated_by" => $updated_by,
            "status" => $status
        );    
        array_push($result, $category_item);
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



