<?php
require "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$ClientsId = trim($_REQUEST['ClientsId']);

$check_Bookings_Clients = new Database();
$query_check_Bookings_Clients = "SELECT * FROM Bookings_Clients
    WHERE BookingsId = :BookingsId
    AND ClientsId = :ClientsId
;";
$check_Bookings_Clients->query($query_check_Bookings_Clients);
$check_Bookings_Clients->bind(':BookingsId', $BookingsId);
$check_Bookings_Clients->bind(':ClientsId', $ClientsId);
$rowCount = $check_Bookings_Clients->rowCount();
if ($rowCount == 0) {
    //inserting data to the table Bookings_Clients
    $insert_Bookings_Clients = new Database();
    $query_insert_Bookings_Clients = "INSERT INTO Bookings_Clients (
        BookingsId,
        ClientsId
        ) VALUES(
        :BookingsId,
        :ClientsId
        )
    ;";
    $insert_Bookings_Clients->query($query_insert_Bookings_Clients);
    $insert_Bookings_Clients->bind(':BookingsId', $BookingsId);
    $insert_Bookings_Clients->bind(':ClientsId', $ClientsId);
    if($insert_Bookings_Clients->execute()) {
        header("location:booking_addExistingClient.php?BookingsId=$BookingsId");
    }
}
else {
    header("location:booking_addExistingClient.php?BookingsId=$BookingsId");
}

?>
