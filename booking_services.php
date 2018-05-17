<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
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
                            <th colspan="6">Flights</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rows_Flights = getRows_Services('2', $BookingsId);

                    foreach ($rows_Flights as $row_Flights) {
                        echo "<form action=\"#\" method=\"post\">";
                        echo "<tr>";
                        echo "<td style=\"display:none;\"><input type=\"number\" value=\"$row_Flights->ServicesId\"></td>";
                        echo "<td>".date('d-M-y', strtotime($row_Flights->Date_in))."</td>";
                        echo "<td>".$row_Flights->SupplierName."</td>";
                        echo "<td>".$row_Flights->Flight_no."</td>";
                        echo "<td>".$row_Flights->Pick_up." - ".$row_Flights->Drop_off."</td>";
                        echo "<td>ETD:<input type=\"time\" value=\"$row_Flights->Pick_up_time\">&nbsp;";
                        echo "ETA:<input type=\"time\" value=\"$row_Flights->Drop_off_time\"></td>";
                        $rows_ServiceStatus = getRows_ServiceStatus($row_Flights->StatusId);
                        echo "<td><select name=\"StatusId\">";
                        foreach ($rows_ServiceStatus as $row_ServiceStatus) {
                            echo "<option>$row_ServiceStatus->Code</option>";
                        }
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
