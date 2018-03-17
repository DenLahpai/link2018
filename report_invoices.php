<?php
require "functions.php";

if(isset($_REQUEST['buttonInvoiceDate'])) {
    $InvoiceDate1 = $_REQUEST['InvoiceDate1'];
    $InvoiceDate2 = $_REQUEST['InvoiceDate2'];
    $rows_Invoices = get_InvoiceReport_Filterby_InvoiceDate();
}

foreach ($rows_Invoices as $row_Invoices) {
//
}
?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Invoices Report";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Invoices Report";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form report invoices" action="#" method="post">
                    <ul>
                        <li style="font-weight:bold; text-align: center;">Enter Search Criteria</li>
                        </li>
                        <li>
                            <label for="InvoiceDate1">Invoice From:</label>
                            <input type="date" name="InvoiceDate1" id="InvoiceDate1"
                            value="<?php echo $InvoiceDate1; ?>">
                            <label for="InvoiceDate2">Until:</label>
                            <input type="date" name="InvoiceDate2" id="InvoiceDate2"
                            value="<?php echo $InvoiceDate2; ?>">
                            <button type="submit" name="buttonInvoiceDate">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Invoice Date</th>
                            <th>USD</th>
                            <th>MMK</th>
                            <th>Status</th>
                            <th>Method</th>
                            <th>Invoice No</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($rows_Invoices as $row_Invoices) {
                        echo "<tr>";
                        echo "<td><a href=\"booking_invoiceEdit.php?InvoiceNo=$row_Invoices->InvoiceNo\">Edit</a></td>";
                        echo "<td>".$row_Invoices->Reference."</td>";
                        echo "<td>".$row_Invoices->BookingsName."</td>";
                        echo "<td>".$row_Invoices->CorporatesName."</td>";
                        echo "<td>".date('d-m-y', strtotime($row_Invoices->InvoiceDate))."</td>";
                        echo "<td>".$row_Invoices->USD."</td>";
                        echo "<td>".$row_Invoices->MMK."</td>";
                        echo "<td>".$row_Invoices->Status."</td>";
                        echo "<td>".$row_Invoices->Method."</td>";
                        echo "<td>".$row_Invoices->InvoiceNo."</td>";
                        echo "<td><a href=\"invoice_receipt.php?InvoiceNo=$row_Invoices->InvoiceNo\" target=\"_blank\">Receipt</a></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>