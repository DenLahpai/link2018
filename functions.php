<?php
require "../conn/conn.php";

//function to get one date from the table Users
function get_row_Users($UsersId) {
    $get_row_Users = new Database();
    $query_get_row_Users = "SELECT * FROM Users WHERE Id = :UsersId ;";
    $get_row_Users->query($query_get_row_Users);
    $get_row_Users->bind(':UsersId', $UsersId);
    return $r = $get_row_Users->resultset();
}

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

//This cool function that converts number to words doesn't belong to me
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

?>
