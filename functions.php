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

//function to get rows from the table Cities
function getRows_Cities($CitiesId) {
    $database = new Database();
    if(empty($CitiesId) || $CitiesId == "" || $CitiesId == NULL) {
        $query = "SELECT
            Cities.Id,
            Cities.AirportCode,
            Cities.City,
            Cities.CountryCode,
            Countries.Country,
            Countries.Region
            FROM Cities LEFT JOIN Countries
            ON Cities.CountryCode = Countries.Code
        ;";
        $database->query($query);
        return $r = $database->resultset();
    }
    else {
        $query = "SELECT
            Cities.Id,
            Cities.AirportCode,
            Cities.City,
            Cities.CountryCode,
            Countries.Code,
            Countries.Country,
            Countries.Region
            FROM Cities LEFT JOIN Countries
            ON Cities.CountryCode = Countries.Code
            WHERE Cities.Id = :CitiesId
        ;";
        $database->query($query);
        $database->bind(':CitiesId', $CitiesId);
        return $r = $database->resultset();
    }
}

//function to get rows from the table Countries
function getRows_Countries($CountriesId) {
    $database = new Database();
    if (empty($CountriesId) || $CountriesId == "" || $CountriesId == NULL) {
        $query = "SELECT * FROM Countries";
        $database->query($query);
    }
    else {
        $query = "SELECT * FROM Countries
            WHERE Id = :CountriesId
        ;";
        $database->query($query);
        $database->bind(':CountriesId', $CountriesId);
    }
    return $r = $database->resultset();
}

//function to get rows from the table Corporates
function getRows_Corporates() {
    $database = new Database();
    $query = "SELECT
        Corporates.Id,
        Corporates.Name,
        Corporates.Chain,
        Corporates.Type,
        Countries.Country,
        Corporates.Email,
        Corporates.Website
        FROM Corporates, Countries
        WHERE Corporates.CountryCode = Countries.Code
        ORDER BY Corporates.Name
    ;";
    $database->query($query);
    $database->execute();
    return $r = $database->resultset();
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

//function to get rows from the table Invoices
function getRows_Invoices($BookingsId) {
    $getRows_Invoices = new Database();

    if(empty($BookingsId)) {
        $query_getRows_Invoices = "SELECT * FROM Invoices ORDER BY Id";
    }
    else {
        $query_getRows_Invoices = "SELECT * FROM Invoices WHERE BookingsId = :BookingsId ORDER BY Id;";
    }

    $getRows_Invoices->query($query_getRows_Invoices);
    $getRows_Invoices->bind(':BookingsId', $BookingsId);
    return $r = $getRows_Invoices->resultset();
}

//function to generate select options for titles
function selectTitles($Title) {
    if ($Title == 'Mr.'){
        echo "<option value=\"Mr.\" selected=\"selected\">Mr.</option>";
        echo "<option value=\"Ms.\">Ms.</option>";
        echo "<option value=\"Mrs.\">Mrs.</option>";
    }
    elseif ($Title == 'Ms.'){
        echo "<option value=\"Mr.\">Mr.</option>";
        echo "<option value=\"Ms.\" selected=\"selected\">Ms.</option>";
        echo "<option value=\"Mrs.\">Mrs.</option>";
    }
    elseif ($Title == 'Mrs.') {
        echo "<option value=\"Mr.\">Mr.</option>";
        echo "<option value=\"Ms.\">Ms.</option>";
        echo "<option value=\"Mrs.\" selected=\"selected\">Mrs.</option>";
    }
    else {
        echo "<option value=\"\">Select</option>";
        echo "<option value=\"Mr.\">Mr.</option>";
        echo "<option value=\"Ms.\">Ms.</option>";
        echo "<option value=\"Mrs.\">Mrs.</option>";
    }
}

//function to get data from the table Clients
function getRows_Clients($BookingsId) {
    $getRows_Clients = new Database();
    if($BookingsId == NULL || empty($BookingsId)) {
        $query_getRows_Clients = "SELECT
            Clients.Id,
            Clients.Title,
            Clients.FirstName,
            Clients.LastName,
            Clients.PassportNo,
            Clients.PassportExpiry,
            Clients.NRCNo,
            Clients.DOB,
            Clients.Country,
            Clients.FrequentFlyer,
            Clients.Company,
            Clients.Phone,
            Clients.Email,
            Clients.Website
            FROM Clients ORDER BY Clients.Id DESC
        ;";
    }
    else {
        $query_getRows_Clients = "SELECT
            Clients.Id,
            Clients.Title,
            Clients.FirstName,
            Clients.LastName,
            Clients.PassportNo,
            Clients.PassportExpiry,
            Clients.NRCNo,
            Clients.DOB,
            Clients.Country,
            Clients.FrequentFlyer,
            Clients.Company,
            Clients.Phone,
            Clients.Email,
            Clients.Website
            FROM Clients, Bookings_Clients
            WHERE Bookings_Clients.ClientsId = Clients.Id
            AND Bookings_Clients.BookingsId = :BookingsId
        ;";
    }
    $getRows_Clients->query($query_getRows_Clients);
    $getRows_Clients->bind(':BookingsId', $BookingsId);
    return $rows_Clients = $getRows_Clients->resultset();
}

//function to get row from the Table Clients
function getRow_Clients($ClientsId) {
    $getRow_Clients = new Database();
    $query_getRow_Clients = "SELECT * FROM Clients WHERE Id = :ClientsId ;";
    $getRow_Clients->query($query_getRow_Clients);
    $getRow_Clients->bind(':ClientsId', $ClientsId);
    return $r = $getRow_Clients->resultset();
}

//function to get rows from the table Suppliers
function getRows_Suppliers($SuppliersId) {
    $database = new Database();
    if (empty($SuppliersId) || $SuppliersId == NULL) {
        $query = "SELECT * FROM Suppliers ORDER BY Name ;";
    }
    else {
        $query = "SELECT * FROM Suppliers
        WHERE Id = :SuppliersId
        ;";
    }
    $database->query($query);
    $database->bind(':SuppliersId', $SuppliersId);
    return $r = $database->resultset();
}

//function to get rows from the table ServiceStatus
function getRows_ServiceStatus($ServiceStatusId) {
    $database = new Database();
    if (empty($ServiceStatusId) || $ServiceStatusId == NULL) {
        $query = "SELECT * FROM ServiceStatus ORDER BY Id";
    }
    else {
        $query = "SELECT * FROM ServiceStatus
        WHERE Id = :ServiceStatusId";
    }
    $database->query($query);
    $database->bind(':ServiceStatusId', $ServiceStatusId);
    return $r = $database->resultset();
}

//functionto get rows from the table ServiceType
function getRows_ServiceType($ServiceTypeId) {
    $database = new Database();
    if (empty($ServiceTypeId) || $ServiceTypeId == NULL) {
        $query = "SELECT * FROM ServiceType ORDER BY Id";
    }
    else {
        $query = "SELECT * FROM ServiceType
        WHERE Id = :ServiceTypeId
        ;";
    }
    $database->query($query);
    $database->bind(':ServiceTypeId', $ServiceTypeId);
    return $r = $database->resultset();
}

//function to get rows from the table SupplierContacts
function getRows_SupplierContacts($SupplierContactsId) {
    $database = new Database();
    if (empty($SupplierContactsId) || $SupplierContactsId == NULL || $SupplierContactsId == "") {
        $query = "SELECT
            SupplierContacts.Id,
            SupplierContacts.Title,
            SupplierContacts.FirstName,
            SupplierContacts.LastName,
            SupplierContacts.SupplierId,
            Suppliers.Name AS SupplierName,
            SupplierContacts.Email,
            SupplierContacts.Phone
            FROM SupplierContacts, Suppliers
            WHERE Suppliers.Id = SupplierContacts.SupplierId
            ORDER BY Id
        ;";
    }
    else {
        $query = "SELECT
            SupplierContacts.Id,
            SupplierContacts.Title,
            SupplierContacts.FirstName,
            SupplierContacts.LastName,
            SupplierContacts.SupplierId,
            Suppliers.Name AS SupplierName,
            SupplierContacts.Email,
            SupplierContacts.Phone
            FROM SupplierContacts, Suppliers
            WHERE Suppliers.Id = SupplierContacts.SupplierId
            AND SupplierContacts.Id = :SupplierContactsId
        ;";
    }
    $database->query($query);
    $database->bind(':SupplierContactsId', $SupplierContactsId);
    return $r = $database->resultset();
}

//function to get data from the table Cost
function getRows_Cost($ServiceTypeId, $CostId) {
    $database = new Database();
    if (empty($CostId)) {
        $query = "SELECT
            Cost.Id,
            Cost.SupplierId,
            Cost.ServiceTypeId,
            Cost.Service,
            Cost.Additional,
            Cost.StartDate,
            Cost.EndDate,
            Cost.MaxPax,
            Cost.Cost1_USD,
            Cost.Cost1_MMK,
            Cost.Cost2_USD,
            Cost.Cost2_MMK,
            Cost.Cost3_USD,
            Cost.Cost3_MMK,
            Suppliers.Name AS SupplierName,
            Suppliers.City
            FROM Cost, Suppliers
            WHERE Cost.SupplierId = Suppliers.Id
            AND Cost.ServiceTypeId = :ServiceTypeId
            ORDER BY Cost.Id ;";
        $database->query($query);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }
    else {
        $query = "SELECT
            Cost.Id,
            Cost.SupplierId,
            Cost.ServiceTypeId,
            Cost.Service,
            Cost.Additional,
            Cost.StartDate,
            Cost.EndDate,
            Cost.MaxPax,
            Cost.Cost1_USD,
            Cost.Cost1_MMK,
            Cost.Cost2_USD,
            Cost.Cost2_MMK,
            Cost.Cost3_USD,
            Cost.Cost3_MMK,
            Suppliers.Name AS SupplierName,
            Suppliers.City
            FROM Cost LEFT JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            WHERE Cost.Id = :CostId ;";
        $database->query($query);
        $database->bind(':CostId', $CostId);
    }
    return $r = $database->resultset();
}

//function to get data from the table Services_booking
function getRows_Services($ServiceTypeId, $BookingsId) {
    $database = new Database;
    $query = "SELECT
        Services_booking.Id AS ServicesId,
        Services_booking.CostId AS CostId,
        Services_booking.Date_in AS Date_in,
        Services_booking.Date_out AS Date_out,
        Services_booking.Pax AS Pax,
        Services_booking.Sgl AS Sgl,
        Services_booking.Dbl AS Dbl,
        Services_booking.Twn AS Twn,
        Services_booking.Tpl AS Tpl,
        Services_booking.Quantity AS Quantity,
        Services_booking.Flight_no AS Flight_no,
        Services_booking.Pick_up AS Pick_up,
        Services_booking.Drop_off AS Drop_off,
        Services_booking.Pick_up_time AS Pick_up_time,
        Services_booking.Drop_off_time AS Drop_off_time,
        Services_booking.Remark AS Remark,
        Services_booking.Spc_rq AS Spc_rq,
        Services_booking.StatusId AS StatusId,
        Services_booking.Cfm_no AS Cfm_no,
        Services_booking.Cfm_by AS Cfm_by,
        Services_booking.Cost1_USD AS Cost1_USD,
        Services_booking.Cost1_MMK AS Cost1_MMK,
        Services_booking.Cost2_USD AS Cost2_USD,
        Services_booking.Cost2_MMK AS Cost2_MMK,
        Services_booking.Cost3_USD AS Cost3_USD,
        Services_booking.Cost3_MMK AS Cost3_MMK,
        Services_booking.Total_cost_USD AS Total_cost_USD,
        Services_booking.Total_cost_MMK AS Total_cost_MMK,
        Services_booking.Markup AS Markup,
        Services_booking.Sell_USD AS Sell_USD,
        Services_booking.Sell_MMK AS Sell_MMK,
        Suppliers.Name AS SupplierName,
        Suppliers.City AS City,
        Cost.Service AS Service,
        Cost.Additional AS Additional,
        Cost.SupplierId AS SupplierId,
        ServiceStatus.Code AS StatusCode
        FROM Services_booking
        LEFT OUTER JOIN Cost
        ON Services_booking.CostId = Cost.Id
        LEFT OUTER JOIN Suppliers
        ON Cost.SupplierId = Suppliers.Id
        LEFT OUTER JOIN ServiceStatus
        ON Services_booking.StatusId = ServiceStatus.Id
        WHERE Cost.ServiceTypeId = :ServiceTypeId
        AND Services_booking.BookingsId = :BookingsId
        ORDER BY Services_booking.Date_in
    ;";
    $database->query($query);
    $database->bind(':ServiceTypeId', $ServiceTypeId);
    $database->bind(':BookingsId', $BookingsId);
    return $r = $database->resultset();
}

//function to filter suppliers by service type
function filter_rows_Suppliers($ServiceTypeId) {
    $database = new Database;
    $query = "SELECT DISTINCT
        Suppliers.Id AS SupplierId,
        Suppliers.Name AS SupplierName
        FROM Suppliers LEFT JOIN Cost
        ON Suppliers.Id = Cost.SupplierId
        WHERE Cost.ServiceTypeId = :ServiceTypeId
    ;";
    $database->query($query);
    $database->bind(':ServiceTypeId', $ServiceTypeId);
    return $r = $database->resultset();
}

//function to search services to be added in a booking
function searchServices() {
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $SupplierId = $_REQUEST['SupplierId'];
    $Date_in = $_REQUEST['Date_in'];
    $Quantity = $_REQUEST['Quantity'];
    $Markup = $_REQUEST['Markup'];

    $database = new Database;
    $query = "SELECT
        Cost.Id,
        Cost.SupplierId,
        Suppliers.Name AS SuppliersName,
        Cost.Service,
        Cost.Additional,
        Cost.MaxPax,
        Cost.Cost1_USD,
        Cost.Cost1_MMK
        FROM Cost LEFT JOIN Suppliers
        ON Cost.SupplierId = Suppliers.Id
        WHERE ServiceTypeId = :ServiceTypeId
        AND SupplierId = :SupplierId
        AND StartDate <= :Date_in
        AND EndDate >= :Date_in
    ;";
    $database->query($query);
    $database->bind(':ServiceTypeId', $ServiceTypeId);
    $database->bind(':SupplierId', $SupplierId);
    $database->bind(':Date_in', $Date_in);
    return $r = $database->resultset();
}

//fucntion to get data from the table Services_booking
function getRows_Services_booking($Services_bookingId) {
    $database = new Database();

    if ($Services_bookingId == "" || $Services_bookingId == NULL || empty($Services_bookingId)) {
        $query = "SELECT
            Services_booking.Id AS ServicesId,
            Services_booking.BookingsId AS BookingsId,
            Services_booking.CostId AS CostId,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_out AS Date_out,
            Services_booking.Pax AS Pax,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            Services_booking.Remark AS Remark,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.StatusId AS StatusId,
            Services_booking.Cfm_no AS Cfm_no,
            Services_booking.Cfm_by AS Cfm_by,
            Services_booking.Cost1_USD AS Cost1_USD,
            Services_booking.Cost1_MMK AS Cost1_MMK,
            Services_booking.Cost2_USD AS Cost2_USD,
            Services_booking.Cost2_MMK AS Cost2_MMK,
            Services_booking.Cost3_USD AS Cost3_USD,
            Services_booking.Cost3_MMK AS Cost3_MMK,
            Services_booking.Total_cost_USD AS Total_cost_USD,
            Services_booking.Total_cost_MMK AS Total_cost_MMK,
            Services_booking.Markup AS Markup,
            Services_booking.Sell_USD AS Sell_USD,
            Services_booking.Sell_MMK AS Sell_MMK,
            Suppliers.Name AS SupplierName,
            Suppliers.Address AS SupplierAddress,
            Suppliers.Phone AS SupplierPhone,
            Suppliers.City AS City,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Cost.SupplierId AS SupplierId,
            ServiceStatus.Code AS StatusCode
            FROM Services_booking
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
        ;";
        $database->query($query);
    }
    else {
        $query = "SELECT
            Services_booking.Id AS ServicesId,
            Services_booking.BookingsId AS BookingsId,
            Services_booking.CostId AS CostId,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_out AS Date_out,
            Services_booking.Pax AS Pax,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            Services_booking.Remark AS Remark,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.StatusId AS StatusId,
            Services_booking.Cfm_no AS Cfm_no,
            Services_booking.Cfm_by AS Cfm_by,
            Services_booking.Cost1_USD AS Cost1_USD,
            Services_booking.Cost1_MMK AS Cost1_MMK,
            Services_booking.Cost2_USD AS Cost2_USD,
            Services_booking.Cost2_MMK AS Cost2_MMK,
            Services_booking.Cost3_USD AS Cost3_USD,
            Services_booking.Cost3_MMK AS Cost3_MMK,
            Services_booking.Total_cost_USD AS Total_cost_USD,
            Services_booking.Total_cost_MMK AS Total_cost_MMK,
            Services_booking.Markup AS Markup,
            Services_booking.Sell_USD AS Sell_USD,
            Services_booking.Sell_MMK AS Sell_MMK,
            Suppliers.Name AS SupplierName,
            Suppliers.Address AS SupplierAddress,
            Suppliers.City AS City,
            Suppliers.Phone AS SupplierPhone,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Cost.SupplierId AS SupplierId,
            ServiceStatus.Code AS StatusCode
            FROM Services_booking
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Services_booking.Id = :Services_bookingId
        ;";
        $database->query($query);
        $database->bind(':Services_bookingId', $Services_bookingId);
        return $r = $database->resultset();
    }
}

///             Funcitons for Reports /////

//function to get data for report_invoices
function get_report_invoices() {

    $database = new Database();
    $InvoiceDate1 = $_REQUEST['InvoiceDate1'];
    $InvoiceDate2 = $_REQUEST['InvoiceDate2'];
    $CorporatesId = $_REQUEST['CorporatesId'];
    $InvoicesStatus = $_REQUEST['InvoicesStatus'];
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';

    if ($InvoiceDate2 == NULL || $InvoiceDate2 == "") {
        $InvoiceDate2 = $InvoiceDate1;
    }

    if ($InvoiceDate1 == NULL && $CorporatesId == NULL && $InvoicesStatus == NULL  && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
        ;";
        $database->query($query);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 == NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId == NULL & $InvoicesStatus == NULL && $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
            AND Invoices.Status <= :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 == NULL && $CorporatesId == NULL && $InvoicesStatus != NULL & $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search == NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
            AND Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,:created2
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
            AND Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search != NULL) {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
    else {
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
            AND Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
}

//Function to get the data for the report_bookings.php
function get_report_bookings() {
    $database = new Database();
    $CorporatesId = $_REQUEST['CorporatesId'];
    $Status = $_REQUEST['Status'];
    $ArvDate1 = $_REQUEST['ArvDate1'];
    $ArvDate2 = $_REQUEST['ArvDate2'];
    $created1 = $_REQUEST['created1'];
    $created2 = $_REQUEST['created2'];
    $search = $_REQUEST['search'];
    $mySearch = '%'.$search.'%';

    if ($ArvDate2 == NULL) {
        $ArvDate2 = $ArvDate1;
    }

    if ($created2 == NULL) {
        $created2 = date('Y-m-d', strtotime($created1.'+'.'1'.'days'));
    }

    if ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL && $created1 == NULL && $search == NULL) {
        $num =  "00000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
        ;";
        $database->query($query);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL && $created1 == NULL && $search != NULL) {
        $num = "00001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL && $created1 != NULL && $search == NULL) {
        $num = "00010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL && $created1 == NULL && $search == NULL) {
        $num = "00100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL && $created1 == NULL && $search == NULL) {
        $num = "01000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL && $created1 == NULL && $search == NULL) {
        $num = "10000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "00011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind('created1', $created1);
        $database->bind('created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "00101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "00110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL & $created1 == NULL && $search != NULL) {
        $num = "01001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search == NULL) {
        $num = "01010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search == NULL) {
        $num = "01100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL & $created1 == NULL && $search != NULL) {
        $num = "10001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL & $created1 != NULL && $search == NULL) {
        $num = "10010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 == NULL && $search == NULL) {
        $num = "10100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 == NULL && $search == NULL) {
        $num = "11000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search != NULL) {
        $num = "00111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "01011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "01101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "01110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "10011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "10101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "10110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 == NULL && $search != NULL) {
        $num = "11001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status >= :Statuss
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search == NULL) {
        $num = "11010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search == NULL) {
        $num = "11100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 != NULL && $search != NULL) {
        $num = "01111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search != NULL) {
        $num = "10111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "11011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "11101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "11110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    else {
        $num = "11111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }
    return $r = $database->resultset();
}

//function to get data from the table Services_booking
function get_report_Services_booking() {
    $database = new Database();
    $CorporatesId = $_REQUEST['CorporatesId'];
    $SuppliersId = $_REQUEST['SuppliersId'];
    $Date_in1 = $_REQUEST['Date_in1'];
    $Date_in2 = $_REQUEST['Date_in2'];
    if ($Date_in2 == NULL) {
        $Date_in2 = $Date_in1;
    }
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';

    if ($CorporatesId == NULL && $SuppliersId == NULL && $Date_in1 == NULL && $search == NULL) {
        $num = '0000';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
        ;";
        $database->query($query);
    }
    elseif ($CorporatesId == NULL && $SuppliersId == NULL && $Date_in1 == NULL && $search != NULL) {
        $num = '0001';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Suppliers.Name,
            Cost.Service,
            Cost.Additional,
            Services_booking.Flight_no,
            Services_booking.Pick_up,
            Services_booking.Drop_off
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
    }
    elseif ($CorporatesId == NULL && $SuppliersId == NULL && $Date_in1 != NULL && $search == NULL) {
        $num = '0010';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Services_booking.Date_in >= :Date_in1
            AND Services_booking.Date_in <= :Date_in2
        ;";
        $database->query($query);
        $database->bind(':Date_in1', $Date_in1);
        $database->bind(':Date_in2', $Date_in2);
    }
    elseif ($CorporatesId == NULL && $SuppliersId != NULL && $Date_in1 == NULL && $search == NULL) {
        $num = '0100';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':SuppliersId', $SuppliersId);
    }
    elseif ($CorporatesId != NULL && $SuppliersId == NULL && $Date_in1 == NULL && $search == NULL) {
        $num = '1000';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Corporates.Id = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
    }
    elseif ($CorporatesId == NULL && $SuppliersId == NULL && $Date_in1 != NULL && $search != NULL) {
        $num = '0011';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Services_booking.Date_in >= :Date_in1
            AND Services_booking.Date_in <= :Date_in2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Suppliers.Name,
            Cost.Service,
            Cost.Additional,
            Services_booking.Flight_no,
            Services_booking.Pick_up,
            Services_booking.Drop_off
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':Date_in1', $Date_in1);
        $database->bind(':Date_in2', $Date_in2);
    }
    elseif ($CorporatesId == NULL && $SuppliersId != NULL && $Date_in1 == NULL && $search != NULL) {
        $num = '0101';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Suppliers.Id = :SuppliersId
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Suppliers.Name,
            Cost.Service,
            Cost.Additional,
            Services_booking.Flight_no,
            Services_booking.Pick_up,
            Services_booking.Drop_off
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':SupplierId', $SuppliersId);
        $database->bind(':mySearch', $mySearch);
    }
    elseif ($CorporatesId == NULL && $SuppliersId != NULL && $Date_in1 != NULL && $search == NULL) {
        $num = '0110';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Services_booking.Date_in >= :Date_in1
            AND Services_booking.Date_in <= :Date_in2
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':Date_in1', $Date_in1);
        $database->bind(':Date_in2', $Date_in2);
        $database->bind(':SuppliersId', $SuppliersId);
    }
    elseif ($CorporatesId != NULL && $SuppliersId == NULL && $Date_in1 == NULL && $search != NULL) {
        $num = '1001';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Corporates.Id = :CorporatesId
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Suppliers.Name,
            Cost.Service,
            Cost.Additional,
            Services_booking.Flight_no,
            Services_booking.Pick_up,
            Services_booking.Drop_off
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
    }
    elseif ($CorporatesId != NULL && $SuppliersId == NULL && $Date_in1 != NULL && $search == NULL) {
        $num = '1010';
        $query = "SELECT
            Bookings.Reference AS Reference,
            Bookings.Name AS BookingsName,
            Bookings.Pax AS Pax,
            Bookings.Status AS BookingsStatus,
            Corporates.Name AS CoporatesName,
            Suppliers.Name AS SuppliersName,
            Cost.Service AS Service,
            Cost.Additional AS Additional,
            Services_booking.Date_in AS Date_in,
            Services_booking.Date_Out AS Date_Out,
            Services_booking.Sgl AS Sgl,
            Services_booking.Dbl AS Dbl,
            Services_booking.Twn AS Twn,
            Services_booking.Tpl AS Tpl,
            Services_booking.Quantity AS Quantity,
            Services_booking.Flight_no AS Flight_no,
            Services_booking.Pick_up AS Pick_up,
            Services_booking.Drop_off AS Drop_off,
            Services_booking.Pick_up_time AS Pick_up_time,
            Services_booking.Drop_off_time AS Drop_off_time,
            ServiceStatus.Code AS ServiceStatusCode,
            Services_booking.Spc_rq AS Spc_rq,
            Services_booking.Cfm_no AS Cfm_no
            FROM Services_booking
            LEFT OUTER JOIN Bookings
            ON Services_booking.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates
            ON Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Cost
            ON Services_booking.CostId = Cost.Id
            LEFT OUTER JOIN Suppliers
            ON Cost.SupplierId = Suppliers.Id
            LEFT OUTER JOIN ServiceStatus
            ON Services_booking.StatusId = ServiceStatus.Id
            WHERE Services_booking.Date_in >= :Date_in1
            AND Services_booking.Date_in <= :Date_in2
            AND Corporates.Id = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':Date_in1', $Date_in1);
        $database->bind(':Date_in2', $Date_in2);
        $database->bind(':CorporatesId', $CorporatesId);
    }
    // TODO

    echo $num;
    return $database->resultset();
}

?>
