<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServicesId = $_REQUEST['ServicesId'];
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $updateService = New Database;
    if ($ServiceTypeId == 1) {
        $StatusId = $_REQUEST['StatusId'];
        $Cfm_no = $_REQUEST['Cfm_no'];

        $query_updateService = "UPDATE Services_booking SET
            StatusId = :StatusId,
            Cfm_no = :Cfm_no
            WHERE Id = :ServicesId
        ;";
        $updateService->query($query_updateService);
        $updateService->bind(':StatusId', $StatusId);
        $updateService->bind(':Cfm_no', $Cfm_no);
        $updateService->bind(':ServicesId', $ServicesId);
        $updateService->execute();
    }
    if ($ServiceTypeId == 2) {
        $Date_in = $_REQUEST['Date_in'];
        $Flight_no = $_REQUEST['Flight_no'];
        $Pick_up_time = $_REQUEST['Pick_up_time'];
        $Drop_off_time = $_REQUEST['Drop_off_time'];
        $StatusId = $_REQUEST['StatusId'];
        $Cfm_no = $_REQUEST['Cfm_no'];

        $query_updateService = "UPDATE Services_booking SET
            Date_in = :Date_in,
            Flight_no = :Flight_no,
            Pick_up_time = :Pick_up_time,
            Drop_off_time = :Drop_off_time,
            StatusId = :StatusId,
            Cfm_no = :Cfm_no
            WHERE Id = :ServicesId
        ;";
        $updateService->query($query_updateService);
        $updateService->bind(':Date_in', $Date_in);
        $updateService->bind(':Flight_no', $Flight_no);
        $updateService->bind(':Pick_up_time', $Pick_up_time);
        $updateService->bind(':Drop_off_time', $Drop_off_time);
        $updateService->bind(':StatusId', $StatusId);
        $updateService->bind(':Cfm_no', $Cfm_no);
        $updateService->bind(':ServicesId', $ServicesId);
        $updateService->execute();
    }

    if ($ServiceTypeId == 3) {
        $Date_in = $_REQUEST['Date_in'];
        $Pick_up = trim($_REQUEST['Pick_up']);
        $Drop_off = trim($_REQUEST['Drop_off']);
        $Pick_up_time = $_REQUEST['Pick_up_time'];
        $Drop_off_time = $_REQUEST['Drop_off_time'];
        $StatusId = $_REQUEST['StatusId'];

        $query_updateService = "UPDATE Services_booking SET
            Date_in = :Date_in,
            Pick_up = :Pick_up,
            Drop_off = :Drop_off,
            Pick_up_time = :Pick_up_time,
            Drop_off_time = :Drop_off_time,
            StatusId = :StatusId
            WHERE Id = :ServicesId
        ;";
        $updateService->query($query_updateService);
        $updateService->bind(':Date_in', $Date_in);
        $updateService->bind(':Pick_up', $Pick_up);
        $updateService->bind(':Drop_off', $Drop_off);
        $updateService->bind(':Pick_up_time', $Pick_up_time);
        $updateService->bind(':Drop_off_time', $Drop_off_time);
        $updateService->bind(':StatusId', $StatusId);
        $updateService->bind(':ServicesId', $ServicesId);
        $updateService->execute();
    }
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Services: ";
    $title .= $Reference;
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Services: ".$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <section>
                <a href="<?php echo "booking_addServices.php?BookingsId=$BookingsId";?>">
                    <button type="button" name="button">Add Service</button></a>

                <a href="<?php echo "hotelsConfirmation.php?BookingsId=$BookingsId"; ?>" target="_blank">
                    <button type="button" name="button">Hotels Confirmation</button></a>
                <a href="<?php echo "flightsConfirmation.php?BookingsId=$BookingsId";?>" target="_blank">
                    <button type="button" name="button">Flights Confirmation</button></a>
                <a href="<?php echo "transfersConfirmation.php?BookingsId=$BookingsId";?>" target="_blank">
                    <button type="button" name="button">Transfers Confirmation</button></a>
            </section>
            <main>
                <h3>Services in this Booking</h3>
                <h4>
                    Flights
                </h4>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    $rows_Flights = getRows_Services('2', $BookingsId);
                    foreach ($rows_Flights as $row_Flights) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<form action=\"#\" method=\"post\">";
                        echo "<ul>";
                        echo "<li style=\"display:none;\"><input type=\"number\" name=\"ServicesId\" value=\"$row_Flights->ServicesId\"></li>";
                        echo "<li style=\"display:none;\"><input type=\"number\" name=\"ServiceTypeId\" value=\"2\"></li>";
                        echo "<li>Date: &nbsp;<input type=\"date\" name=\"Date_in\" value=\"$row_Flights->Date_in\"></li>";
                        echo "<li>Airline: &nbsp;".$row_Flights->SupplierName."</li>";
                        echo "<li>Flight: &nbsp;<input type=\"text\" name=\"Flight_no\" value=\"$row_Flights->Flight_no\" size=\"8\"></li>";
                        echo "<li>Route: &nbsp;".$row_Flights->Pick_up." - ".$row_Flights->Drop_off."</li>";
                        echo "<li>ETD:&nbsp;<input type=\"time\" name=\"Pick_up_time\" value=\"$row_Flights->Pick_up_time\">&nbsp;";
                        echo "ETA:&nbsp;<input type=\"time\" name=\"Drop_off_time\" value=\"$row_Flights->Drop_off_time\"></li>";
                        $rows_ServiceStatus = getRows_ServiceStatus(NULL);
                        echo "<li>Status: &nbsp; <select name=\"StatusId\">";
                        if ($row_Flights->StatusId == "" || $row_Flights->StatusId == NULL || empty($row_Flights->StatusId)) {
                            echo "<option value=\"\">Select</option>";
                            foreach ($rows_ServiceStatus as $row_ServiceStatus){
                                echo "<option value=\"$row_ServiceStatus->Id\">$row_ServiceStatus->Code</option>";
                            }
                        }
                        else {
                            foreach ($rows_ServiceStatus as $row_ServiceStatus){
                                if ($row_ServiceStatus->Id == $row_Flights->StatusId) {
                                    echo "<option value=\"$row_ServiceStatus->Id\" selected>$row_ServiceStatus->Code</option>";
                                }
                                else {
                                    echo "<option value=\"$row_ServiceStatus->Id\">$row_ServiceStatus->Code</option>";
                                }
                            }
                        }
                        echo "</select></li>";
                        echo "<li>Cfm: &nbsp; <input type=\"text\" name=\"Cfm_no\" value=\"$row_Flights->Cfm_no\"><li>";
                        echo "<li><button type=\"submit\">Update</button>";
                        echo "<a href=\"editServices_booking.php?Services_bookingId=$row_Flights->ServicesId\">";
                        echo "<button type=\"button\">Edit</button></a>";
                        echo "<a href=\"deleteServices_booking.php?Services_bookingId=$row_Flights->ServicesId\">";
                        echo "<button type=\"button\">Delete</button></a></li>";
                        echo "</form>";
                        echo "</div><!-- end of grid-item -->";
                    }
                    ?>
                </div><!-- end of grid-div -->
                <h4>
                    Hotels
                </h4>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    $rows_hotels = getRows_Services('1', $BookingsId);
                    foreach ($rows_hotels as $row_hotels) {
                        echo "<div class=\"grid-item\"><!-- div-item -->";
                        echo "<form action=\"#\" method=\"post\">";
                        echo "<ul>";
                        echo "<li style=\"display:none;\"><input type=\"number\" name=\"ServicesId\" value=\"$row_hotels->ServicesId\"></li>";
                        echo "<li style=\"display:none;\"><input type=\"number\" name=\"ServiceTypeId\" value=\"1\"></li>";
                        echo "<li>".$row_hotels->SupplierName."</li>";
                        echo "<li>".$row_hotels->Service."</li>";
                        echo "<li>Check-in: &nbsp;".date("d-M-y", strtotime($row_hotels->Date_in))."</li>";
                        echo "<li>Check-out: &nbsp;".date("d-M-y", strtotime($row_hotels->Date_out))."</li>";
                        echo "<li>Nights: &nbsp; ".$row_hotels->Quantity."</li>";
                        echo "<li>Room(s): &nbsp; ";
                        if ($row_hotels->Sgl > 0 ) {
                            echo $row_hotels->Sgl." Sgl, ";
                        }
                        if ($row_hotels->Dbl > 0 ) {
                            echo $row_hotels->Dbl. " Dbl, ";
                        }
                        if ($row_hotels->Twn > 0) {
                            echo $row_hotels->Twn." Twn, ";
                        }
                        if ($row_hotels->Tpl > 0) {
                            echo $row_hotels->Tpl." Tpl";
                        }
                        $rows_ServiceStatus = getRows_ServiceStatus(NULL);
                        echo "<li>Status: &nbsp; <select name=\"StatusId\">";
                        if ($row_hotels->StatusId == "" || $row_hotels->StatusId == NULL || empty($row_hotels->StatusId)) {
                            echo "<option value=\"\">Select</option>";
                            foreach ($rows_ServiceStatus as $row_ServiceStatus){
                                echo "<option value=\"$row_ServiceStatus->Id\">$row_ServiceStatus->Code</option>";
                            }
                        }
                        else {
                            foreach ($rows_ServiceStatus as $row_ServiceStatus){
                                if ($row_hotels->StatusId == $row_ServiceStatus->Id) {
                                    echo "<option value=\"$row_ServiceStatus->Id\" selected>$row_ServiceStatus->Code</option>";
                                }
                                else {
                                    echo "<option value=\"$row_ServiceStatus->Id\">$row_ServiceStatus->Code</option>";
                                }
                            }
                        }
                        echo "</select></li>";
                        echo "<li>Cfm: &nbsp; <input type=\"text\" name=\"Cfm_no\" value=\"$row_hotels->Cfm_no\"><li>";
                        echo "<li><a href=\"hotelVoucher.php?Services_bookingId=$row_hotels->ServicesId\" target=\"_blank\">Hotel Voucher</a></li>";
                        echo "<li><button type=\"submit\">Update</button>";
                        echo "<a href=\"editServices_booking.php?Services_bookingId=$row_hotels->ServicesId\">";
                        echo "<button type=\"button\">Edit</button></a>";
                        echo "<a href=\"deleteServices_booking.php?Services_bookingId=$row_hotels->ServicesId\">";
                        echo "<button type=\"button\">Delete</button></a></li>";
                        echo "</select></li>";
                        echo "</ul>";
                        echo "</form>";
                        echo "</div><!-- end of grid-item -->";
                    }
                    ?>
                </div><!-- end of grid-div -->
                <h4>Land Transfers</h4>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_transfers = getRows_Services('3', $BookingsId);
                    foreach ($rows_transfers as $row_transfers) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<form action=\"#\" method=\"post\">";
                        echo "<ul>";
                        echo "<li style=\"display:none;\"><input type=\"number\" name=\"ServicesId\" value=\"$row_transfers->ServicesId\"></li>";
                        echo "<li style=\"display:none;\"><input type=\"number\" name=\"ServiceTypeId\" value=\"3\"></li>";
                        echo "<li>".$row_transfers->SupplierName."</li>";
                        echo "<li>Date: <input type=\"date\" name=\"Date_in\" value=\"$row_transfers->Date_in\"></li>";
                        echo "<li>".$row_transfers->Service." ($row_transfers->Additional)"."</li>";
                        echo "<li>Pick-up: <input type=\"text\" name=\"Pick_up\" value=\"$row_transfers->Pick_up\"> @ ";
                        echo "<input type=\"time\" name=\"Pick_up_time\" value=\"$row_transfers->Pick_up_time\"></li>";
                        echo "<li>Drop-off: <input type=\"text\" name=\"Drop_off\" value=\"$row_transfers->Drop_off\"> @ ";
                        echo "<input type=\"time\" name=\"Drop_off_time\" value=\"$row_transfers->Drop_off_time\"></li>";

                        $rows_ServiceStatus = getRows_ServiceStatus(NULL);
                        echo "<li>Status: &nbsp; <select name=\"StatusId\">";
                        if ($row_transfers->StatusId == "" || $row_transfers->StatusId == NULL || empty($row_transfers->StatusId)) {
                            echo "<option value=\"\">Select</option>";
                            foreach ($rows_ServiceStatus as $row_ServiceStatus){
                                echo "<option value=\"$row_ServiceStatus->Id\">$row_ServiceStatus->Code</option>";
                            }
                        }
                        else {
                            foreach ($rows_ServiceStatus as $row_ServiceStatus){
                                if ($row_ServiceStatus->Id == $row_transfers->StatusId) {
                                    echo "<option value=\"$row_ServiceStatus->Id\" selected>$row_ServiceStatus->Code</option>";
                                }
                                else {
                                    echo "<option value=\"$row_ServiceStatus->Id\">$row_ServiceStatus->Code</option>";
                                }
                            }
                        }
                        echo "</select></li>";

                        echo "<li><button type=\"submit\">Update</button>";

                        echo "<a href=\"editServices_booking.php?Services_bookingId=$row_transfers->ServicesId\">";
                        echo "<button type=\"button\">Edit</button></a>";

                        echo "<a href=\"deleteServices_booking.php?Services_bookingId=$row_transfers->ServicesId\">";
                        echo "<button type=\"button\">Delete</button></a></li>";
                        echo "</ul>";
                        echo "</form>";
                        echo "</div><!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html";?>
    </body>
</html>
