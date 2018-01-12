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
                <table>
                    <thead>
                        <tr>
                            <th colspan="7">Invoices</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>USD</th>
                            <th>MMK</th>
                            <th>Status</th>
                            <th>Paid On</th>
                            <th>#</th>
                        </tr>
                        <?php
                        foreach ($rows_Invoices as $row_Invoices) {
                            echo "<tr>";
                            echo "<td>".$row_Invoices->InvoiceNo."</td>";
                            echo "<td>".date('d-m-Y', strtotime($row_Invoices->InvoiceDate))."</td>";
                            echo "<td>".$row_Invoices->USD."</td>";
                            echo "<td>".$row_Invoices->MMK."</td>";
                            echo "<td>".$row_Invoices->Status."</td>";
                            $thisYear = date('Y', strtotime($row_Invoices->PaidOn));
                            if($thisYear >= 2018) {
                                echo "<td>".date('d-m-Y', strtotime($row_Invoices->PaidOn))."</td>";
                            }
                            else {
                                echo "<td></td>";
                            }
                            $InvoiceNo = $row_Invoices->InvoiceNo;
                            echo "<td><a href=\"booking_invoiceEdit.php?InvoiceId=$InvoiceNo\">
                            <button>Edit</button></a>";
                            echo "<a href=\"\"><button>Receipt</button></a></td>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
	    <main>
		<table>
			
		</table>
	    </main>
        </div><!-- end of content -->
    </body>
</html>
