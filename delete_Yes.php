<?php
require_once "functions.php";
$Services_bookingId = $_REQUEST['Services_bookingId'];
$rows_Services_booking = getRows_Services_booking($Services_bookingId);
foreach ($rows_Services_booking as $row_Services_booking) {
    $BookingsId = $row_Services_booking->BookingsId;
}

$database = new Database();
$query = "UPDATE Services_booking SET
    BookingsId = :BookingsId
    WHERE Id = :Services_bookingId
;";
$database->query($query);
$database->bind(':BookingsId', 0);
$database->bind(':Services_bookingId', $Services_bookingId);
if ($database->execute()) {
    header("location:booking_services.php?BookingsId=$BookingsId");
}

?>
