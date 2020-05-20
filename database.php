<?php
class Database{

    private $host = "localhost";
    private $db_name = "goabrigo";
    private $username = "radhika";
    private $password = "Test!123";

    /*
     $host = "localhost";
    $db_name = "goabrigo";
    $username = "radhika";
    $password = "Test!123";*/
    public $conn;

    public function getConnection(){

        $this -> conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
/*
 $query = "INSERT INTO `register` (`name`, `email`, `mobno`,`address1`,`address2`.`address3`,`pincode`) VALUES ('" . $firstname . "', '" . $email . "', '". $mobno . "','" . $address1 . "','" . $address2 . "','" . $address3 . "','" . pincode . "');
		$result = $this->database->executeQuery($query);
 */
    public function executeQuery(){
        $db = $this->getConnection();
        $query = "INSERT INTO register(`name`, `email`, `mobno`,`address1`,`address2`.`address3`,`pincode`) VALUES (:firstname, :email, :mobno, :address1,:address2,:address3,:pincode)";
        $stmnt = $db->prepare($query);
        $stmnt->bindParam(':firstname', $firstname);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':mobno', $mobno);
        $stmnt->bindParam(':address1', $address1);
        $stmnt->bindParam(':address2', $address2);
        $stmnt->bindParam(':address3', $address3);
        $stmnt->bindParam(':pincode', $pincode);
        // execute query
        $stmnt->execute();
        echo "done.";
        $conn = null;
    }

}

?>
