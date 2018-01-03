<?php
session_start();

class Database {
    private $database;
    private $stm;

    //connect to db
    public function __construct() {

        try {
            $this->database = new PDO("mysql: host=127.0.0.1; dbname=denlpmm_link2018",
                "denlpmm_link", "LinkCorp@2017");
            $this->database->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $this->database->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_OBJ);
        }
        catch (PDOException $e){
            throw new Exception($e->getMessage());
        }
    }

    public function query($query) {
        $this->stm = $this->database->prepare($query);
    }

    public function bind($params, $value) {
        // if(is_null($type)) {
        //     switch (true) {
        //         case is_int($value):
        //             $type = PDO:: PARAM_INT;
        //             break;
        //         case is_bool($value):
        //              $type = PDO:: PARAM_BOOL;
        //              break;
        //         case is_null($value):
        //             $type = PDO:: PARAM_NULL;
        //         default:
        //             $type = PDO:: PARAM_STR;
        //             break;
        //     }
        // }
        $this->stm->bindParam($params, $value);
    }

    public function execute() {
        return $this->stm->execute();
    }

    public function resultset() {
        $this->execute();
        return $this->stm->fetchAll(PDO:: FETCH_OBJ);
    }

    public function rowCount() {
        $this->execute();
        return $this->stm->rowCount();
    }

    public function generate_Reference($r) {
        if ($r <= 9 ) {
		$zeros = '00';
    	}
    	else if ($r <= 99) {
    		$zeros = '0';
    	}
    	else {
    		$zeros = '';
    	}
    	$reference = 'LNK-'.$zeros.$r;
    	return $reference;
    }
}

//Uncomment the two lines below to get error reporting as a dev enviroment.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// checking if a user is logged in
 if (!isset($_SESSION['UsersId'])){
    header("location:index.php");
    $_SESSION['msg_error'] = "Session Expired! Please log in again!";
}

////////////////////////////////Error notifications/////////////////////////////////////
$msg_error = NULL; //used as variable in the header to display error messages
$empty_field = "Please make sure to fill out all the required field(s)!";
$duplicate_entry = "Duplicated entry!";
$connection_problem = "There was a connection problem with the database server!";

?>
