<?php
require "functions.php";

$BookingsId = $_REQUEST['BookingsId'];

//getting one data from Bookings
$row_Bookings = get_row_Bookings($BookingsId);
foreach ($row_Bookings AS $data_Bookings) {
    $Name = $data_Bookings->BookingsName;
    $CorporatesId = $data_Bookings->CorporatesId;
    $ArvDate = $data_Bookings->ArvDate;
    $Pax = $data_Bookings->Pax;
    $Status = $data_Bookings->Status;
    $Remark = $data_Bookings->Remark;
    $Exchange = $data_Bookings->Exchange;

}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "Invoice";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Invoice";
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <main>
                <form class="form table" action="index.html" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <label for="Addressee">Addressee:</label>
                                </th>
                                <th>
                                    <input type="text" name="Addressee" id="Addressee"
                                    placeholder="To" required>
                                </th>
                                <th>
                                    <label for="InvoiceNo">Invoice No:</label>
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>
                                    <label for="Address">Address:</label>
                                </th>
                                <th>
                                    <input type="text" name="Address" id="Address" placeholder="Address">
                                </th>
                                <th>
                                    <label for="InvoiceDate">Date:</label>
                                </th>
                                <th>
                                    <input type="date" name="InvoiceDate" id="InvoiceDate"
                                    value="<?php echo date("Y-m-d"); ?>">
                                </th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
