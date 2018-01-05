<?php
require "functions.php";
//getting one data from Bookings
$BookingsId = $_REQUEST['BookingsId'];
$getRow_Bookings = new Database();
$query_getRow_Bookings = "SELECT
    Bookings.Reference,
    Bookings.Name AS BookingsName,
    Bookings.CorporatesId,
    Corporates.Name AS CorporatesName,
    Bookings.ArvDate,
    Bookings.Pax,
    Bookings.Status,
    Bookings.Remark,
    Bookings.Exchange
    FROM Bookings, Corporates
    WHERE Bookings.CorporatesId = Corporates.Id
    AND Bookings.Id = :BookingsId
;";
$getRow_Bookings->query($query_getRow_Bookings);
$getRow_Bookings->bind(':BookingsId', $BookingsId);
$row_Bookings = $getRow_Bookings->resultset();
foreach ($row_Bookings AS $data_Bookings) {
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

    </body>
</html>
