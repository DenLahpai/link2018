<?php
require "functions.php";

$BookingsId = $_REQUEST['BookingsId'];

//getting one data from Bookings
$row_Bookings = get_row_Bookings($BookingsId);
foreach ($row_Bookings AS $data_Bookings) {
    $Reference = $data_Bookings->Reference;
    $Name = $data_Bookings->BookingsName;
    $CorporatesId = $data_Bookings->CorporatesId;
    $ArvDate = $data_Bookings->ArvDate;
    $Pax = $data_Bookings->Pax;
    $Status = $data_Bookings->Status;
    $Remark = $data_Bookings->Remark;
    $Exchange = $data_Bookings->Exchange;
}

// $BookingsId = NULL;
$rows_Invoices = getRows_Invoices($BookingsId);

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = $data_Bookings->Reference;
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Summary: ".$data_Bookings->Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <section>
                <div class="grid-div">
                    <?php
                    foreach ($rows_Invoices as $row_Invoices) {
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li>Invoice No: ".$row_Invoices->InvoiceNo."</li>";
                        echo "<li>Invoiec Date: ".date('d-m-Y', strtotime($row_Invoices->InvoiceDate))."</li>";
                        echo "<li>Amount: ".$row_Invoices->USD." USD</li>";
                        echo "<li>Amount: ".$row_Invoices->MMK." MMK</li>";
                        echo "<li>Status: ".$row_Invoices->Status." on: ";
                        $thisYear = date('Y', strtotime($row_Invoices->PaidOn));
                        if($thisYear >= 2018) {
                            echo date('d-m-Y', strtotime($row_Invoices->PaidOn))."</li>";
                        }
                        $InvoiceNo = $row_Invoices->InvoiceNo;
                        echo "<li><a href=\"booking_invoiceEdit.php?InvoiceNo=$InvoiceNo\">
                        Edit</a></li>";
                        echo "<li><a href=\"invoice_receipt.php?InvoiceNo=$InvoiceNo\" target=\"_blank\">Receipt</a></li>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </section>
	    <main>
            <div class="grid-div"><!-- grid-div -->
                <!-- TODO Services -->
            </div><!-- end of grid-div -->
	    </main>
        </div><!-- end of content -->
    </body>
</html>
