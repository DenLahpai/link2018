<?php
require "functions.php";

//Getting data from the table Invoices and InvoiceHeader
$InvoiceNo = trim($_REQUEST['InvoiceNo']);
$datas_Invoice = getData_Invoice($InvoiceNo);
foreach ($datas_Invoice as $data_Invoice) {
    $BookingsId = $data_Invoice->BookingsId;
    $USD = $data_Invoice->USD;
    $MMK = $data_Invoice->MMK;
}

if ($USD == 0) {
    $currency = 'MMK';
}
else {
    $currency = 'USD';
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

$datas_Users = get_row_Users($_SESSION['UsersId']);
foreach ($datas_Users as $data_Users) {
    $Fullname = $data_Users->Fullname;
}

$method = 0 ;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_REQUEST['method'];

    //updating the table Invoices
    $PaidOn = date('Y-m-d');
    $Status = 'Paid';

    $update_Invoices = new Database();
    $query_update_Invoices = "UPDATE Invoices SET
        PaidOn = :PaidOn,
        Status = :Status,
        MethodId = :Method
        WHERE InvoiceNo = :InvoiceNo
    ;";
    $update_Invoices->query($query_update_Invoices);
    $update_Invoices->bind(':PaidOn', $PaidOn);
    $update_Invoices->bind(':Status', $Status);
    $update_Invoices->bind(':Method', $method);
    $update_Invoices->bind(':InvoiceNo', $InvoiceNo);
    $update_Invoices->execute();
}


?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/print.css">
    <title>
        <?php echo "Receipt ".$Reference." - ".$InvoiceNo ; ?>
    </title>
</head>
    <body>
        <div class="content"><!-- content -->
            <?php include "includes/print_header.html"; ?>
            <section>
                <h2>Receipt</h2>
                <table>
                    <thead>
                        <tr>
                            <td>Addressee:</td>
                            <td>
                                <?php echo $data_Invoice->Addressee; ?>
                            </td>
                            <td>Date:</td>
                            <td>
                                <?php echo date('d-m-y'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <?php echo $data_Invoice->Address; ?>
                            </td>
                            <td>Invoice No:</td>
                            <td>
                                <?php echo $InvoiceNo;?>
                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <?php echo $data_Invoice->City; ?>
                            </td>
                            <td>
                                Booking Reference:
                            </td>
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
                                <?php echo $data_Bookings->BookingsName; ?>
                            </td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount in <?php echo $currency; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $year = 2018;
                        foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                            if(date('Y',strtotime($row_InvoiceDetails->Date)) >= $year){
                                echo "<tr>";
                                echo "<td>".date('d-m-Y', strtotime($row_InvoiceDetails->Date))."</td>";
                                echo "<td>".$row_InvoiceDetails->Description."</td>";
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
                            <th colspan="2">TOTAL in <?php echo $currency; ?></th>
                            <th>
                                <?php echo $currency.' '. $sum; ?>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <p>
                Amount in <?php echo $currency; ?> :
                <?php
                $total = round($sum, 2);
                echo convert_number_to_words($total). ' ONLY!<br>';
                ?>
                Sales Person: <?php echo $Fullname; ?>
                </p>
            </main>
            <aside>
                <form action="#" method="post">
                    Payment Method:
                    <select name="method" onchange="this.form.submit()">
                        <option value="0">Select Payment Option</option>
                    <?php
                    if ($method == 1) {
                        echo "<option value=\"1\" selected>Cash in $currency</option>";
                        echo "<option value=\"2\">UBO</option>";
                        echo "<option value=\"3\">Visa / Master</option>";
                        echo "<option value=\"4\">KBZ</option>";
                        echo "<option value=\"5\">CB</option>";
                    }
                    else if ($method == 2) {
                        echo "<option value=\"1\">Cash</option>";
                        echo "<option value=\"2\" selected>UBO</option>";
                        echo "<option value=\"3\">Visa / Master</option>";
                        echo "<option value=\"4\">KBZ</option>";
                        echo "<option value=\"5\">CB</option>";
                    }
                    else if ($method == 3) {
                        echo "<option value=\"1\" >Cash</option>";
                        echo "<option value=\"2\">UBO</option>";
                        echo "<option value=\"3\" selected>Visa / Master</option>";
                        echo "<option value=\"4\">KBZ</option>";
                        echo "<option value=\"5\">CB</option>";
                    }
                    else if ($method == 4) {
                        echo "<option value=\"1\" >Cash</option>";
                        echo "<option value=\"2\">UBO</option>";
                        echo "<option value=\"3\">Visa / Master</option>";
                        echo "<option value=\"4\" selected>KBZ</option>";
                        echo "<option value=\"5\">CB</option>";
                    }
                    else if ($method == 5) {
                        echo "<option value=\"1\" >Cash</option>";
                        echo "<option value=\"2\">UBO</option>";
                        echo "<option value=\"3\">Visa / Master</option>";
                        echo "<option value=\"4\"KBZ</option>";
                        echo "<option value=\"5\" selected>CB</option>";
                    }
                    else {
                        echo "<option value=\"1\" >Cash</option>";
                        echo "<option value=\"2\">UBO</option>";
                        echo "<option value=\"3\">Visa / Master</option>";
                        echo "<option value=\"4\">KBZ</option>";
                        echo "<option value=\"5\">CB</option>";
                    }
                    ?>
                    </select>
                </form>
                <?php
                // switch ($method) {
                //     case '1':
                //         include "includes/cash.html";
                //         break;
                //     case '2':
                //         include "includes/uob.html";
                //         break;
                //     case '3':
                //         include "includes/VisaMaster.html";
                //         break;
                //     case '4':
                //         include "includes/kbz.html";
                //         break;
                //     default:
                //         # code...
                //         break;
                // }
                ?>
            </aside>
        </div><!-- end of content -->
    </body>
</html>
