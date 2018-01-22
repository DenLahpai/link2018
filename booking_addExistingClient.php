<?php
require "functions.php";

$BookingsId = $_REQUEST['BookingsId'];

//getting one data from Bookings
$row_Bookings = get_row_Bookings($BookingsId);
foreach ($row_Bookings AS $data_Bookings) {
    $Name = $data_Bookings->BookingsName;
    $Reference = $data_Bookings->Reference;
    $CorporatesId = $data_Bookings->CorporatesId;
    $ArvDate = $data_Bookings->ArvDate;
    $Pax = $data_Bookings->Pax;
    $Status = $data_Bookings->Status;
    $Remark = $data_Bookings->Remark;
    $Exchange = $data_Bookings->Exchange;
}

$rows_Clients = getRows_Clients(NULL);

?>
<!DOCTYPE html>
<html>
    <?php
    $title = 'Clients: '.$Reference;
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = 'Add Client to : '.$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <main>
                <?php
                foreach ($rows_Clients as $row_Clients) {
                    echo "<ul>";
                    echo "<li>";
                    echo "<a href=\"addClient.php?BookingsId=$BookingsId&ClientsId=$row_Clients->Id\">";
                    echo "<button>Add</button></a>   ";
                    echo $row_Clients->Title." ";
                    echo $row_Clients->FirstName." ";
                    echo $row_Clients->LastName." | ";
                    echo $row_Clients->PassportNo." | ";
                    echo $row_Clients->NRCNo." | ";
                    echo $row_Clients->FrequentFlyer;
                    echo "</li>";
                    echo "</ul>";
                }
                ?>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
