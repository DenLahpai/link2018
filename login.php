<?php
require "conn.php";

//getting data from the form
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Username = $_REQUEST['Username'];
    $Password = $_REQUEST['Password'];

    $database = new Database();
    $query = "SELECT * FROM Users
        WHERE BINARY Username = :Username
        AND BINARY Password = :Password
    ;";
    $database->query($query);
    $database->bind(':Username', $Username);
    $database->bind(':Password', $Password);
    $rowCount = $database->rowCount();
    $rows = $database->resultset();
    if($rowCount > 0) {
        $_SESSION['msg_error'] = NULL;
        header("location:home.php");
        foreach($rows as $row) {
            $_SESSION['UsersId'] = $row->Id;
        }
    }
    else {
        $_SESSION['msg_error'] = "Wrong Username or Password!";
        header("location:index.php");
    }
}

?>
