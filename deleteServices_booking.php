<?php
require_once "functions.php";

//getting Services_bookingId
$Services_bookingId = trim($_REQUEST['Services_bookingId']);
$rows_Services_booking = getRows_Services_booking($Services_bookingId);
foreach ($rows_Services_booking as $row_Services_booking) {
    $BookingsId = $row_Services_booking->BookingsId;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $title = "Delete Service: ";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $pageTitle = "Delete Service";
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <main>
                <h3>
                    Are you sure you want to delete the following service?
                </h3>
                <br>
                <ul>
                    <li style="text-align: center;">
                        <?php echo date('d-M-y', strtotime($row_Services_booking->Date_in))." : ".$row_Services_booking->SupplierName.", ".$row_Services_booking->Service; ?>
                    </li>
                </ul>
                <br>
                <p style="text-align: center;">
                    <a href="<?php echo "delete_Yes.php?Services_bookingId=$Services_bookingId"; ?>">
                    <button type="button" name="button">Yes</button></a>
                    <a href="<?php echo "booking_services.php?BookingsId=$BookingsId"; ?> ">
                    <button type="button" name="button">No</button></a>
                </p>
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
