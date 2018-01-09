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

//Submitting data to the tables Invoices, Invoice_header and Invoice_details
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Gettings data from all the forms
    $Addressee = trim($_REQUEST['Addressee']);
    $Address = trim($_REQUEST['Address']);
    $City = trim($_REQUEST['City']);
    $Attn = trim($_REQUEST['Attn']);
    $InvoiceDate = $_REQUEST['InvoiceDate'];
    $currency = $_REQUEST['currency'];

    //Generating InvoiceNo
    $generate_invoiceNo = new Database();
    $query_rowCount_Invoices = "SELECT * FROM Invoices ;";
    $generate_invoiceNo->query($query_rowCount_Invoices);
    $rowCount_Invoices = $generate_invoiceNo->rowCount();
    $r = $rowCount_Invoices + 1;
    if($r <= 9) {
        $InvoiceNo = '2018'.'-000'.$r;
    }
    elseif($r <= 99) {
        $InvoiceNo = '2018'.'-00'.$r;
    }
    elseif ($r <= 999) {
        $InvoiceNo = '2018'.'-0'.$r;
    }
    else {
        $InvoiceNo = '2018'.'-'.$r;
    }
    //inserting date to the table InvoiceHeader

    $insert_InvoiceHeader = new Database();
    $query_insert_InvoiceHeader = "INSERT INTO InvoiceHeader (
        InvoiceNo,
        Addressee,
        Address,
        City,
        Attn
        ) VALUES(
        :InvoiceNo,
        :Addressee,
        :Address,
        :City,
        :Attn
        )
    ;";
    $insert_InvoiceHeader->query($query_insert_InvoiceHeader);
    $insert_InvoiceHeader->bind(':InvoiceNo', $InvoiceNo);
    $insert_InvoiceHeader->bind(':Addressee', $Addressee);
    $insert_InvoiceHeader->bind(':Address', $Address);
    $insert_InvoiceHeader->bind(':City', $City);
    $insert_InvoiceHeader->bind(':Attn', $Attn);
    $insert_InvoiceHeader->execute();

    //inserting data to the table InvoiceDetails

    $i = 1;
    while($i <= 20) {
        $date = $_REQUEST["date$i"];
        $Description = trim($_REQUEST["description$i"]);
        $Amount = $_REQUEST["amount$i"];

        $insert_InvoiceDetails = new Database();
        $query_insert_InvoiceDetails = "INSERT INTO InvoiceDetails (
            InvoiceNo,
            Date,
            Description,
            $currency
            ) VALUES(
            :InvoiceNo,
            :date,
            :Description,
            :Amount
            )
        ;";

        $insert_InvoiceDetails->query($query_insert_InvoiceDetails);
        $insert_InvoiceDetails->bind(':InvoiceNo', $InvoiceNo);
        $insert_InvoiceDetails->bind(':date', $date);
        $insert_InvoiceDetails->bind(':Description', $Description);
        $insert_InvoiceDetails->bind(':Amount', $Amount);
        $insert_InvoiceDetails->execute();
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

    //insert data to the table Invoices
    $insert_Invoices = new Database();
    $query_insert_Invoices = "INSERT INTO Invoices (
        InvoiceNo,
        BookingsId,
        InvoiceDate,
        $currency,
        Status
        ) VALUES(
        :InvoiceNo,
        :BookingsId,
        :InvoiceDate,
        :sum,
        :Status
        )
    ;";
    $Status = "Invoiced";
    $insert_Invoices->query($query_insert_Invoices);
    $insert_Invoices->bind(':InvoiceNo', $InvoiceNo);
    $insert_Invoices->bind(':BookingsId', $BookingsId);
    $insert_Invoices->bind('InvoiceDate', $InvoiceDate);
    $insert_Invoices->bind(':sum', $sum);
    $insert_Invoices->bind(':Status', $Status);
    if($insert_Invoices->execute()) {
        header("location:generate_invoice.php?InvoiceNo=$InvoiceNo&currency=$currency");
    }
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
            <section>
                <form class="form invoice_header" id="form_header" action="#" method="post">
                    <table>
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td>
                                    <ul>
                                        <li>
                                            <label for="Addressee">Addressee:</label>
                                            <input type="text" name="Addressee" id="Addressee" placeholder="To" required>
                                        </li>
                                        <li>
                                            <label for="Address">Address:</label>
                                            <input type="text" name="Address" id="Address" placeholder="Address">
                                        </li>
                                        <li>
                                            <label for="City">City:</label>
                                            <input type="text" name="City" id="City" placeholder="City">
                                        </li>
                                        <li>
                                            <label for="Attn">Attn:</label>
                                            <input type="text" name="Attn" id="Attn" placeholder="Attention">
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            <label for="InvoiceDate">Invoice Date:</label>
                                            <input type="date" name="InvoiceDate" id="InvoiceDate"
                                            value="<?php echo date("Y-m-d"); ?>">
                                        </li>
                                        <li>
                                            <label for="InvoiceNo">Invoice No:</label>
                                            <input type="text" value="2018-XXXX" readonly>
                                        </li>
                                        <li>
                                            <label for="Reference">Reference:</label>
                                            <input type="text" id="Reference" value="<?php echo $Reference; ?>" readonly>
                                        </li>
                                        <li>
                                            <label for="Name">Booking Name:</label>
                                            <input type="text" id="Name" value="<?php echo $Name; ?>" readonly>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </section>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while($i <= 20) {
                                include "includes/invoice_details.html";
                                $i++;
                            }
                            ?>
                            <tr>
                                <th colspan="3">
                                    <select name="currency">
                                        <option value="USD">USD</option>
                                        <option value="MMK">MMK</option>
                                    </select>
                                    <button type="submit" name="buttonSubmit">Submit</button>
                                </th>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
