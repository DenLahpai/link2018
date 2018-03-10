<?php
require "functions.php";


$rows_Invoices = getReport_bySearch_Invoice(NULL);
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
        <?php include "includes/search.html"; ?>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Invoices Report";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form report invoices" action="#" method="post">
                    <ul>
                        <li style="font-weight:bold; text-align: center;">Filters</li>
                        <li>
                            <label for="CorporatesId">Filter by Comapany:</label>
                            <select name="CorporatesId">
                                <option value="0">Select One</option>
                                <?php
                                $rows_Corporates = getRows_Corporates();
                                foreach ($rows_Corporates as $row_Corporates) {
                                    echo "<option value=\"$row_Corporates->Id\">".$row_Corporates->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="StatusId">Filter by Payment Status:</label>
                            <select name="Status">
                                <option value="0">Select One</option>
                                <?php
                                foreach ($rows_Invoices as $row_Invoices) {
                                    echo "<option value=\"$row_Invoices->Status\">".$row_Invoices->Status."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="from_InvoiceDate">Invoice From:</label>
                            <input type="date" name="from_InvoiceDate" id="from_InvoiceDate">
                            <label for="until_InvoiceDate">Until:</label>
                            <input type="date" name="until_InvoiceDate" id="until_InvoiceDate">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
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
