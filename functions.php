<?php
require "../conn/conn.php";

//function to get one row from the table Bookings
function get_row_Bookings($BookingsId) {

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
    return $row_Bookings = $getRow_Bookings->resultset();
}

?>
