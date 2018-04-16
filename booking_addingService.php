<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$ServiceTypeId = $_REQUEST['ServiceTypeId'];
$SupplierId = $_REQUEST['SupplierId'];
$Date_in = $_REQUEST['Date_in'];
$Quantity = $_REQUEST['Quantity'];
$Markup = $_REQUEST['Markup'];
$CostId = trim($_REQUEST['CostId']);

$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}

//getting Date_out
switch ($ServiceTypeId) {
    case '1':
        $Date_out = date('Y-m-d', strtotime($Date_in."+".$Quantity.'days'));
        $title = "Rooming";
        $pageTitle = "Room(s): ".$Reference;
        break;

    default:
        $Date_out = $Date_in;
        break;
}

?>
<!DOCTYPE html>
<html>
    <?php
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            //TODO Resume here
            ?>
        </div><!-- end of content -->
    </body>
</html>
