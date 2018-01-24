<?php
require "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);

$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}
?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Clients: ".$Reference;
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Clients: ".$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <section>
                <a href="<?php echo "booking_addClients.php?BookingsId=$BookingsId"; ?>">
                    <button type="button" name="button">Add New Client</button></a>
                <a href="<?php echo "booking_addExistingClient.php?BookingsId=$BookingsId"; ?>">
                    <button type="button" name="button">Add Existing Client</button> </a>
            </section>
            <main>
                <h3>Clients in this Booking</h3>
                <?php
                //getting Clients from the booking
                $rows_Clients = getRows_Clients($BookingsId);
                foreach ($rows_Clients as $row_Clients) {
                    echo "<ol>";
                    echo "<li>".$row_Clients->Title;
                    echo " ".$row_Clients->FirstName." ";
                    echo $row_Clients->LastName." | ";
                    echo $row_Clients->NRCNo." | ";
                    echo $row_Clients->PassportNo." | ";
                    echo $row_Clients->FrequentFlyer." | ";
                    echo "<a href=\"clientsEdit.php?ClientsId=$row_Clients->Id\" target=\"_blank\">Edit</a></li>";
                }
                ?>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
