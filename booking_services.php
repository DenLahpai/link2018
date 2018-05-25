<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServicesId = $_REQUEST['ServicesId'];
    $Date_in = $_REQUEST['Date_in'];
    $Flight_no = $_REQUEST['Flight_no'];
    $Pick_up_time = $_REQUEST['Pick_up_time'];
    $Drop_off_time = $_REQUEST['Drop_off_time'];
    $StatusId = $_REQUEST['StatusId'];
    $updateService = New Database;
    $query_updateService = "UPDATE Services_booking SET
        Date_in = :Date_in,
        Flight_no = :Flight_no,
        Pick_up_time = :Pick_up_time,
        Drop_off_time = :Drop_off_time,
        StatusId = :StatusId
        WHERE Id = :ServicesId
    ;";
    $updateService->query($query_updateService);
    $updateService->bind(':Date_in', $Date_in);
    $updateService->bind(':Flight_no', $Flight_no);
    $updateService->bind(':Pick_up_time', $Pick_up_time);
    $updateService->bind(':Drop_off_time', $Drop_off_time);
    $updateService->bind(':StatusId', $StatusId);
    $updateService->bind(':ServicesId', $ServicesId);
    $updateService->execute();
    //TODO DELETE & EDIT Services_booking
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
        <div class="content">
            <?php
            $pageTitle = "Services: ".$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <section>
                <a href="<?php echo "booking_addServices.php?BookingsId=$BookingsId";?>">
                    <button type="button" name="button">Add Service</button>
                </a>
            </section>
            <main>
                <h3>Services in this Booking</h3>
                <table>
                    <thead>
                        <tr>
                            <th colspan="8">Flights &nbsp; <a href="<?php echo "flightsConfirmation.php?BookingsId=$BookingsId"; //TODO ?>" target="_blank">Confirmation</a> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rows_Flights = getRows_Services('2', $BookingsId);

                    foreach ($rows_Flights as $row_Flights) {
                        echo "<form action=\"#\" method=\"post\">";
                        echo "<tr>";
                        echo "<td style=\"display:none;\"><input type=\"number\" name=\"ServicesId\" value=\"$row_Flights->ServicesId\"></td>";
                        echo "<td><input type=\"date\" name=\"Date_in\" value=\"$row_Flights->Date_in\"></td>";
                        echo "<td>".$row_Flights->SupplierName."</td>";
                        echo "<td><input type=\"text\" name=\"Flight_no\" value=\"$row_Flights->Flight_no\" size=\"8\"></td>";
                        echo "<td>".$row_Flights->Pick_up." - ".$row_Flights->Drop_off."</td>";
                        echo "<td>ETD:&nbsp;<input type=\"time\" name=\"Pick_up_time\" value=\"$row_Flights->Pick_up_time\">&nbsp;";
                        echo "ETA:&nbsp;<input type=\"time\" name=\"Drop_off_time\" value=\"$row_Flights->Drop_off_time\"></td>";
                        $rows_ServiceStatus = getRows_ServiceStatus(NULL);
                        echo "<td><select name=\"StatusId\">";
                        if ($row_Flights->StatusId == "") {
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

                        echo "</select></td>";
                        echo "<td><button type=\"submit\">Update</button>";
                        echo "<a href=\"editServices_booking.php?Services_bookingId=ServicesId\">";
                        echo "<button type=\"button\">Edit</button></a>";

                        echo "<a href=\"deleteServices_booking.php?Services_bookingId=ServicesId\">";
                        echo "<button type=\"button\">Delete</button></a>";

                        echo "</form>";
                    }
                    ?>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </main>
        </div>
        <?php include "includes/footer.html";?>
    </body>
</html>
