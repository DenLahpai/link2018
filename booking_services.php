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
                            <th colspan="5">Flights</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
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
