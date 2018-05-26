<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/print.css">
        <title>
            <?php echo "Flights Confirmation - ".$Reference;?>
        </title>
    </head>
    <body>
        <div class="content"><!-- content -->
        <?php include "includes/print_header.html";?>
            <main>
                <h2>Flights Confirmation Status</h2>
                <h3>
                    <?php echo $Reference." - ".$row_Bookings->BookingsName;?>
                </h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Airline</th>
                            <th>Route</th>
                            <th>Flight No</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Status</th>
                            <th>Airline Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rows_Flights = getRows_Services('2', $BookingsId);
                    foreach ($rows_Flights as $row_Flights) {
                        echo "<tr>";
                        echo "<td>".date('d-M-y', strtotime($row_Flights->Date_in))."</td>";
                        echo "<td>".$row_Flights->SupplierName."</td>";
                        echo "<td>".$row_Flights->Pick_up." - ".$row_Flights->Drop_off."</td>";
                        echo "<td>".$row_Flights->Flight_no."</td>";
                        echo "<td>".date('H:i', strtotime($row_Flights->Pick_up_time))."</td>";
                        echo "<td>".date('H:i', strtotime($row_Flights->Drop_off_time))."</td>";
                        echo "<td>".$row_Flights->StatusCode."</td>";
                        echo "<td>".$row_Flights->Cfm_no."</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </main>
            <section>
                <h4>Names:</h4>
                <ol>
                <?php
                $rows_Clients = getRows_CLients($BookingsId);
                foreach ($rows_Clients as $row_Clients) {
                    echo "<li>".$row_Clients->Title." ";
                    echo $row_Clients->FirstName." ";
                    echo $row_Clients->LastName."</li>";
                }
                ?>
                </ol>
            </section>
        </div><!-- end ocf content -->
    </body>
</html>
