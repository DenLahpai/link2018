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

//function to get data from the tables Invoices, InvoiceHeader and InvoiceDetails
function getData_Invoice($InvoiceNo) {
    $getRow = new Database();
    $query = "SELECT
        Invoices.BookingsId AS BookingsId,
        Invoices.InvoiceDate AS InvoiceDate,
        Invoices.USD AS USD,
        Invoices.MMK AS MMK,
        InvoiceHeader.Addressee AS Addressee,
        InvoiceHeader.Address AS Address,
        InvoiceHeader.City AS City,
        InvoiceHeader.Attn AS Attn
        FROM Invoices, InvoiceHeader
        WHERE Invoices.InvoiceNo = InvoiceHeader.InvoiceNo
        AND Invoices.InvoiceNo = :InvoiceNo
    ;";
    $getRow->query($query);
    $getRow->bind(':InvoiceNo', $InvoiceNo);
    return $r = $getRow->resultset();
}

//function to get data from the table InvoiceDetails
function getData_InvoiceDetails($InvoiceNo) {
    $getRow = new Database();
    $query = "SELECT * FROM InvoiceDetails WHERE InvoiceNo = :InvoiceNo ;";
    $getRow->query($query);
    $getRow->bind(':InvoiceNo', $InvoiceNo);
    return $r = $getRow->resultset();
}

?>
