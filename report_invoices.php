<?php
require "functions.php";
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

            </section>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Invoice Date</th>
                            <th>USD</th>
                            <th>MMK</th>
                            <th>Status</th>
                            <th>Method</th>
                            <th>Invoice No</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rows_Invoices = getReport_bySearch_Invoice(NULL);
                    foreach ($rows_Invoices as $row_Invoices) {
                        echo "<tr>";
                        echo "<td>".$row_Invoices->Reference."</td>";
                        echo "<td>".$row_Invoices->BookingsName."</td>";
                        echo "<td>".$row_Invoices->CorporatesName."</td>";
                        echo "<td>".date('d-m-y', strtotime($row_Invoices->InvoiceDate))."</td>";
                        echo "<td>".$row_Invoices->USD."</td>";
                        echo "<td>".$row_Invoices->MMK."</td>";
                        echo "<td>".$row_Invoices->Status."</td>";
                        echo "<td>".$row_Invoices->Method."</td>";
                        echo "<td>".$row_Invoices->InvoiceNo."</td>";
                    }
                    ?>
                    </tbody>
                </table>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
