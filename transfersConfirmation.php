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
            <?php echo "Transfers Confirmation - ".$Reference; ?>
        </title>
    </head>
    <body>
        <div class="content"><!-- content -->
        <?php include "includes/print_header.html"; ?>
            <main>
                <h2>Transfers Confirmation Status</h2>
                <h3>
                    <?php echo $Reference." - ".$row_Bookings->BookingsName; ?>
                </h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Pick-up</th>
                            <th>Drop-off</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rows_transfers = getRows_Services('3', $BookingsId);
                    foreach ($rows_transfers as $row_transfers) {
                        echo "<tr>";
                        echo "<td>".date('d-M-y', strtotime($row_transfers->Date_in))."</td>";
                        echo "<td>".$row_transfers->Service." ($row_transfers->Additional) </td>";
                        echo "<td>".$row_transfers->Pick_up." @ ".date('H:i', strtotime($row_transfers->Pick_up_time))."</td>";
                        echo "<td>".$row_transfers->Drop_off." @ ".date('H:i', strtotime($row_transfers->Drop_off_time))."</td>";
                        echo "<td>".$row_transfers->StatusCode."</td>";
                    }
                    ?>
                    </tbody>
                </table>
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
