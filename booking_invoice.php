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
if(isset($_SERVER['REQUEST_METHOD']) == 'POST') {
    //Gettings data from all the forms
    echo $_REQUEST['Addressee'];
    echo $_REQUEST['date1'];
    echo $_REQUEST['description1'];
    echo $_REQUEST['amount1'];
    echo $_REQUEST['currency'];

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
                        <thead>

                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <ul>
                                        <li>
                                            <label for="Addressee">Addressee:</label>
                                            <input type="text" name="Addressee" id="Addressee" placeholder="To" required>
                                        </li>
                                        <li>
                                            <label for="Addresss">Address:</label>
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
                                            <label for="Date">Invoice Date:</label>
                                            <input type="date" name="Date" id="Date"
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
