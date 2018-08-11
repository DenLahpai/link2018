<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$Date_in = $_REQUEST['Date_in'];
$Quantity = $_REQUEST['Quantity'];
$Markup = $_REQUEST['Markup'];
$CostId = trim($_REQUEST['CostId']);

$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {
    $ServiceTypeId = $row_Cost->ServiceTypeId;
    $SupplierId = $row_Cost->SupplierId;
}

$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
    $Pax = $row_Bookings->Pax;
}

$rows_Suppliers = getRows_Suppliers($SupplierId);
foreach ($rows_Suppliers as $row_Suppliers) {

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
    $title = $Reference;
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Add Service: ".$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";

            switch ($ServiceTypeId) {
                case '1':
                    include "includes/booking_addingServiceAC.php";
                    break;

                case '2':
                    include "includes/booking_addingServiceFL.php";
                    break;

                case '3':
                    include "includes/booking_addingServiceLT.php";
                    break;

                default:
                    // code...
                    break;
            }
            ?>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
