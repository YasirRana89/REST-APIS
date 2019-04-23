<?php
class Database{
     
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "muirisla_apps";
    private $username = "muirisla_appsUse";
    private $password = "hHy=w+0ub4.)";
    public $conn;
 
    // get the database connection
    public function __construct(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            
            return $this->conn;
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        
    }

    public function selectQuery($sql, $where, $extra=''){
        
    }

    public function insertQuery($sql, $bindArray){

    }

    public function updateQuery($sql, $where, $extra=''){

    }
    public function getmyDB()
    {
    if ($this->conn instanceof PDO)
        {
        return $this->conn;
        }
    }
}
?>