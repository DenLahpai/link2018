<?php
require "functions.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "Bookings";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Bookings";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    $getRows_Bookings = new Database();
                    $query_getRows_Bookings = "SELECT
                        Bookings.Id AS BookingsId,
                        Bookings.Reference,
                        Bookings.Name AS BookingName,
                        Corporates.Name AS CorporateName,
                        Bookings.ArvDate,
                        Bookings.Pax,
                        Bookings.Status,
                        Users.Username
                        FROM Bookings, Corporates, Users
                        WHERE Bookings.CorporatesId = Corporates.Id
                        AND Bookings.UserId = Users.Id
                    ;";
                    $getRows_Bookings->query($query_getRows_Bookings);
                    $rows_Bookings = $getRows_Bookings->resultset();
                    foreach ($rows_Bookings as $row_Bookings) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<ul>";
                        echo "<li><a href=\"booking_summary.php?BookingsId=$row_Bookings->BookingsId\">".$row_Bookings->Reference."</a></li>";
                        echo "<li>".$row_Bookings->BookingName;
                        echo " X ".$row_Bookings->Pax." Pers</li>";
                        echo "<li>".$row_Bookings->CorporateName."</li>";
                        echo "<li style=\"font-weight: bold;\">";
                        echo date("d-M-Y", strtotime($row_Bookings->ArvDate))."</li>";
                        echo "<li>".$row_Bookings->Status."</li>";
                        echo "<li style=\"font-style: italic;\">By ";
                        echo $row_Bookings->Username."</li>";
                        echo "<li><a href=\"bookingsEdit.php?BookingsId=$row_Bookings->BookingsId\">Edit</a></li>";
                        echo "</div><!-- end of grid-item --!>";
                    }
                    ?>
                </div><!-- end of grid-div -->
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
