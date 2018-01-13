<?php
require "functions.php";

$InvoiceNo = trim($_REQUEST['InvoiceNo']);
$datas_invoice = getData_Invoice($InvoiceNo);
foreach ($datas_invoice as $data_invoice) {
    $BookingsId = $data_invoice->BookingsId;
    $Addressee = $data_invoice->Addressee;
    $InvoiceDate = $data_invoice->InvoiceDate;
    $Address = $data_invoice->Address;
    $City = $data_invoice->City;
    $Attn = $data_invoice->Attn;
    $USD = $data_invoice->USD;
    $MMK = $data_invoice->MMK;
}

$datas_Bookings = get_row_Bookings($BookingsId);
foreach ($datas_Bookings as $data_Bookings) {
    $Reference = $data_Bookings->Reference;
    $BookingsName = $data_Bookings->BookingsName;

}

//Getting data from the table InvoiceDetails
$rows_InvoiceDetails = getData_InvoiceDetails($InvoiceNo);

//getting currency
if($USD == 0 || empty($USD) || $USD == NULL) {
    $currency = 'MMK';
}
else {
    $currency = 'USD';
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = $Reference;
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Invoice: ".$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <form action="#" method="post">
                    <table>
                        <tbody>
                            <tr>
                                <td>Addressee:</td>
                                <td>
                                    <input type="text" name="Addressee" value="<?php echo $Addressee; ?>">
                                </td>
                                <td>Date:</td>
                                <td>
                                    <input type="date" name="InvoiceDate" value="<?php echo $InvoiceDate; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>
                                    <input type="text" name="Address" value="<?php echo $Address; ?>">
                                </td>
                                <td>Invoice No:</td>
                                <td>
                                    <?php echo $InvoiceNo;?>
                                </td>
                            </tr>
                            <tr>
                                <td>City:</td>
                                <td>
                                    <input type="text" name="City" value="<?php echo $City; ?>">
                                </td>
                                <td>Booking Reference:</td>
                                <td>
                                    <?php echo $Reference; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Attn:</td>
                                <td>
                                    <?php echo $Attn; ?>
                                </td>
                                <td>Booking Name:</td>
                                <td>
                                    <?php echo $BookingsName; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th colspan="2">Service</th>
                                <th>Amount in <?php echo $currency; ?></th>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<input type=\"date\" name=\"Date$i\" value=\"$row_InvoiceDetails->Date\">";
                                echo "</td>";
                                echo "<td colspan=\"2\">";
                                echo "<input type=\"text\" name=\"Description$i\" value=\"$row_InvoiceDetails->Description\">";
                                echo "</td>";
                                echo "<td>";
                                if($currency == 'USD') {
                                    echo "<input type=\"number\" name=\"Amount$i\" value=\"$row_InvoiceDetails->USD\">";
                                }
                                else {
                                    echo "<input type=\"number\" name=\"Amount$i\" value=\"$row_InvoiceDetails->MMK\">";
                                }
                                echo "</td>";
                                echo "<tr>";
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </main>
        </div><!-- end of content -->
		<?php include "includes/footer.html"; ?>
    </body>
</html>
