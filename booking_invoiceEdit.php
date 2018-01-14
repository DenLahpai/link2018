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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Updating Invoice Header
    $Addressee = trim($_REQUEST['Addressee']);
    $Address = trim($_REQUEST['Address']);
    $City = trim($_REQUEST['City']);
    $Attn = trim($_REQUEST['Attn']);

    $update_InvoiceHeader = new Database();
    $query_update_InvoiceHeader = "UPDATE InvoiceHeader SET
        Addressee = :Addressee,
        Address = :Address,
        City = :City,
        Attn = :Attn
    WHERE InvoiceNo = :InvoiceNo
    ;";
    $update_InvoiceHeader->query($query_update_InvoiceHeader);
    $update_InvoiceHeader->bind(':Addressee', $Addressee);
    $update_InvoiceHeader->bind(':Address', $Address);
    $update_InvoiceHeader->bind(':City', $City);
    $update_InvoiceHeader->bind(':Attn', $Attn);
    $update_InvoiceHeader->bind(':InvoiceNo', $InvoiceNo);
    $update_InvoiceHeader->execute();

    //Updating InvoiceDetails
    $i = 1;
    while($i <= 20) {
        $Id = $_REQUEST["Id$i"];
        $Date = $_REQUEST["Date$i"];
        $Description = trim($_REQUEST["Description$i"]);
        $Amount = $_REQUEST["Amount$i"];
        $update_InvoiceDetails = new Database();
        $query_update_InvoiceDetails = "UPDATE InvoiceDetails SET
            Date = :Date,
            Description = :Description,
            $currency = :Amount
            WHERE Id = :Id
        ;";
        $update_InvoiceDetails->query($query_update_InvoiceDetails);
        $update_InvoiceDetails->bind(':Date', $Date);
        $update_InvoiceDetails->bind(':Description', $Description);
        $update_InvoiceDetails->bind(':Amount', $Amount);
        $update_InvoiceDetails->bind(':Id', $Id);
        $update_InvoiceDetails->execute();
        $i++;
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

    //Updating data to the table Invoices
    $InvoiceDate = $_REQUEST['InvoiceDate'];
    $update_Invoices = new Database();
    $query_update_Invoice = "UPDATE Invoices SET
        InvoiceDate = :InvoiceDate,
        $currency = :sum
        WHERE InvoiceNo = :InvoiceNo
    ;";
    $update_Invoices->query($query_update_Invoice);
    $update_Invoices->bind(':InvoiceDate', $InvoiceDate);
    $update_Invoices->bind(':sum', $sum);
    $update_Invoices->bind(':InvoiceNo', $InvoiceNo);
    if($update_Invoices->execute()) {
        header("location: booking_invoiceEdit.php?InvoiceNo=$InvoiceNo");
    }
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
                                    <input type="text" name="Attn" value="<?php echo $Attn; ?>">
                                </td>
                                <td>Booking Name:</td>
                                <td>
                                    <?php echo $BookingsName; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Amount in <?php echo $currency; ?></th>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<input type=\"number\" name=\"Id$i\" value=\"$row_InvoiceDetails->Id\"
                                min=\"1\"max=\"9999\" readonly>";
                                echo "</td>";
                                echo "<td>";
                                echo "<input type=\"date\" name=\"Date$i\" value=\"$row_InvoiceDetails->Date\">";
                                echo "</td>";
                                echo "<td>";
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
                            <tr>
                                <th colspan="4">
                                    <button type="submit" name="button">Update</button>
                                    <a href="<?php echo "print_invoice.php?InvoiceNo=$InvoiceNo&currency=$currency"; ?>" target="_blank">
                                        <button type="button" name="button">Print</button></a>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </main>
        </div><!-- end of content -->
		<?php include "includes/footer.html"; ?>
    </body>
</html>
