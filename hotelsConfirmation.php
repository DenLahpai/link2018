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
            <?php echo "Hotels Confirmation - ".$Reference; ?>
        </title>
    </head>
    <body>
        <!-- content -->
        <div class="content">
            <?php include "includes/print_header.html"; ?>
            <main>
                <h2>Hotels Confirmation Status</h2>
                <h3>
                    <?php echo $Reference." - ".$row_Bookings->BookingsName; ?>
                </h3>
                <table>
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Hotel</th>
                            <th>Room Type</th>
                            <th>Rooms</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>night(s)</th>
                            <th>Status</th>
                            <th>Cfn #</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows_hotels = getRows_Services('1', $BookingsId);
                        foreach ($rows_hotels as $row_hotels) {
                            echo "<tr>";
                            echo "<td>".$row_hotels->City."</td>";
                            echo "<td>".$row_hotels->SupplierName."</td>";
                            echo "<td>".$row_hotels->Service."</td>";
                            echo "<td>";
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
                            echo "</td>";
                            echo "<td>".date('d-M-y', strtotime($row_hotels->Date_in))."</td>";
                            echo "<td>".date('d-M-y', strtotime($row_hotels->Date_out))."</td>";
                            echo "<td>".$row_hotels->Quantity."</td>";
                            echo "<td>".$row_hotels->StatusCode."</td>";
                            echo "<td>".$row_hotels->Cfm_no."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
        <!-- end of contetn -->
    </body>
</html>
