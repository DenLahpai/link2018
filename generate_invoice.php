<?php
require "functions.php";

$currency = trim($_REQUEST['currency']);

//Getting data from the table Invoices and InvoiceHeader
$InvoiceNo = trim($_REQUEST['InvoiceNo']);
$datas_Invoice = getData_Invoice($InvoiceNo);
foreach ($datas_Invoice as $data_Invoice) {
    $BookingsId = $data_Invoice->BookingsId;
}

//Getting data from the table InvoiceDetails
$rows_InvoiceDetails = getData_InvoiceDetails($InvoiceNo);


//getting one data from Bookings
$row_Bookings = get_row_Bookings($BookingsId);
foreach ($row_Bookings AS $data_Bookings) {
    $Name = $data_Bookings->BookingsName;
    $Reference = $data_Bookings->Reference;
}

//getting the SUM
$getSum_InvoiceDetails = new Database();
$query_getSum_InvoiceDetails = "SELECT SUM($currency) AS $currency FROM InvoiceDetails
        WHERE InvoiceNo = :InvoiceNo
;";
$getSum_InvoiceDetails->query($query_getSum_InvoiceDetails);
$getSum_InvoiceDetails->bind(':InvoiceNo', $InvoiceNo);
$results = $getSum_InvoiceDetails->resultset();
foreach ($results as $result) {
    $sum = $result->$currency;
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Invoice: $Reference";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Invoice";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <table>
                    <tbody>
                        <tr>
                            <td>Addressee:</td>
                            <td>
                                <?php echo $data_Invoice->Addressee; ?>
                            </td>
                            <td>Date:</td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($data_Invoice->InvoiceDate)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <?php echo $data_Invoice->Address; ?>
                            </td>
                            <td>Invoice No:</td>
                            <td>
                                <input type="text" name="InvoiceNo" value="<?php echo $InvoiceNo; ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <?php echo $data_Invoice->City; ?>
                            </td>
                            <td>Booking Reference:</td>
                            <td>
                                <?php echo $Reference; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Attn:</td>
                            <td>
                                <?php echo $data_Invoice->Attn; ?>
                            </td>
                            <td>Booking Name:</td>
                            <td>
                                <?php echo $Name; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th colspan="2">Service</th>
                            <th>Amount in <?php echo $currency; ?></th>
                        </tr>
                        <?php
                        $year = 2018;
                        foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                            if(date('Y',strtotime($row_InvoiceDetails->Date)) >= $year){
                                echo "<tr>";
                                echo "<td>".date('d-m-Y', strtotime($row_InvoiceDetails->Date))."</td>";
                                echo "<td colspan='2'>".$row_InvoiceDetails->Description."</td>";
                                if ($currency == 'USD') {
                                    echo "<td>".$row_InvoiceDetails->USD."</td>";
                                }
                                else {
                                    echo "<td>".$row_InvoiceDetails->MMK."</td>";
                                }
                            }
                        }
                        ?>
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th>
                                <?php echo $sum; ?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">
                                Payment Method:
                                <select name="method">
                                    <option value="1">Cash</option>
                                    <option value="2">Credit</option>
                                    <option value="3">CB Bank</option>
                                    <option value="4">KBZ Bank(MMK)</option>
                                    <option value="5">UOB</option>
                                    <option value="6">Visa / Master</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                          <th colspan="4">
                              <a href="#">
                                  <button type="button" name="button">Edit</button></a>
                              <a href="#">
                                  <button type="button" name="button">Print</button></a>
                          </th>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <td>Addressee:</td>
                            <td>
                                <?php echo $data_Invoice->Addressee; ?>
                            </td>
                            <td>Date:</td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($data_Invoice->InvoiceDate)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <?php echo $data_Invoice->Address; ?>
                            </td>
                            <td>Invoice No:</td>
                            <td>
                                <?php echo $InvoiceNo; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <?php echo $data_Invoice->City; ?>
                            </td>
                            <td>Booking Reference:</td>
                            <td>
                                <?php echo $Reference; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Attn:</td>
                            <td>
                                <?php echo $data_Invoice->Attn; ?>
                            </td>
                            <td>Booking Name:</td>
                            <td>
                                <?php echo $Name; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th colspan="2">Service</th>
                            <th>Amount in <?php echo $currency; ?></th>
                        </tr>
                        <?php
                        $year = 2018;
                        foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                            if(date('Y',strtotime($row_InvoiceDetails->Date)) >= $year){
                                echo "<tr>";
                                echo "<td>".date('d-m-Y', strtotime($row_InvoiceDetails->Date))."</td>";
                                echo "<td colspan='2'>".$row_InvoiceDetails->Description."</td>";
                                if ($currency == 'USD') {
                                    echo "<td>".$row_InvoiceDetails->USD."</td>";
                                }
                                else {
                                    echo "<td>".$row_InvoiceDetails->MMK."</td>";
                                }
                            }
                        }
                        ?>
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th>
                                <?php echo $sum; ?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">Payment Method:</th>
                        </tr>

                        <tr>
                          <th colspan="4">
                              <a href="#">
                                  <button type="button" name="button">Edit</button></a>
                              <a href="print_invoice.php?InvoiceNo=$InvoiceNo&currency=$currency;">
                                  <button type="button" name="button">Print</button></a>
                          </th>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div><!-- end of content -->
    </body>
    <?php include "includes/footer.html"; ?>
</html>
