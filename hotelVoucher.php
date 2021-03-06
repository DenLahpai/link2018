<?php
require_once "functions.php";

$Services_bookingId = $_REQUEST['Services_bookingId'];
$rows_hotels = getRows_Services_booking($Services_bookingId);
foreach ($rows_hotels as $row_hotels) {
    $BookingsId = $row_hotels->BookingsId;
}

$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/print.css">
        <title>
            <?php echo "VC ".$row_hotels->SupplierName." - ".$row_Bookings->Reference; ?>
        </title>
    </head>
    <body>
        <!-- content -->
        <div class="content">
        <?php include "includes/print_header.html"; ?>
            <main>
                <h2>Hotel Voucher</h2>
                <ul>
                    <li>
                        To:&nbsp;
                        <span style="font-weight: bold;">
                        <?php echo $row_hotels->SupplierName; ?>
                        </span>
                    </li>
                    <li>
                        Address:&nbsp;
                        <?php echo $row_hotels->SupplierAddress; ?>
                    </li>
                    <li>
                        City:&nbsp;
                        <?php echo $row_hotels->City; ?>
                    </li>
                    <li>
                        Phone:&nbsp;
                        <?php echo $row_hotels->SupplierPhone; ?>
                    </li>
                    <br>
                    <li>
                        Booking Reference:&nbsp;
                        <?php echo $row_Bookings->Reference; ?>
                    </li>
                    <li>
                        Booking Name:&nbsp;
                        <span style="font-weight: bold;">
                            <?php echo $row_Bookings->BookingsName; ?>
                        </span>
                    </li>
                    <li>
                        Room(s):&nbsp;
                        <?php
                        if ($row_hotels->Sgl != 0) {
                            echo $row_hotels->Sgl." Sgl, ";
                        }

                        if ($row_hotels->Dbl != 0) {
                            echo $row_hotels->Dbl." Dbl, ";
                        }

                        if ($row_hotels->Twn != 0) {
                            echo $row_hotels->Twn." Twn, ";
                        }

                        if ($row_hotels->Tpl != 0) {
                            echo $row_hotels->Tpl." Tpl ";
                        }
                        ?>
                    </li>
                    <li>
                        Room Type:&nbsp;
                        <?php echo $row_hotels->Service; ?>
                    </li>
                    <li>
                        Check-in:&nbsp;
                        <span style="font-weight: bold;">
                        <?php echo date('d-M-Y', strtotime($row_hotels->Date_in)); ?>
                        </span>
                        &nbsp;
                        Check-out:&nbsp;
                        <span style="font-weight: bold;">
                        <?php echo date('d-M-Y', strtotime($row_hotels->Date_out)); ?>
                        </span>
                    </li>
                    <li>
                        Night(s):
                        &nbsp;
                        <?php echo $row_hotels->Quantity; ?>
                    </li>
                    <li>
                        Confirmation #:
                        <span style="font-weight: bold;">
                            <?php echo $row_hotels->Cfm_no; ?>
                        </span>
                    </li>
                    <br>
                    <br>
                    <li>
                        <span style="font-style: italic; text-align: center;">
                            Link In Myanmar Travel will settle room charges inclusive of breakfast only! All the incidental charges would be settled by the guest.
                        </span>
                    </li>
                </ul>
            </main>
        </div>
        <!-- end of content  -->
    </body>
</html>
