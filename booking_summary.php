<?php
require "functions.php";

$BookingsId = $_REQUEST['BookingsId'];

//getting one data from Bookings
$row_Bookings = get_row_Bookings($BookingsId);
foreach ($row_Bookings AS $data_Bookings) {
    $Name = $data_Bookings->BookingsName;
    $CorporatesId = $data_Bookings->CorporatesId;
    $ArvDate = $data_Bookings->ArvDate;
    $Pax = $data_Bookings->Pax;
    $Status = $data_Bookings->Status;
    $Remark = $data_Bookings->Remark;
    $Exchange = $data_Bookings->Exchange;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = $data_Bookings->Reference;
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Summary: ".$data_Bookings->Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
        </div><!-- end of content -->
    </body>
</html>
