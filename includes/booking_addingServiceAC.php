<?php
$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {
    $ServiceTypeId = $row_Cost->ServiceTypeId;
    $SupplierId = $row_Cost->SupplierId;
}

if(isset($_REQUEST['buttonSubmit'])) {
    $Date_in = $_REQUEST['Date_in'];
    $Date_out = $_REQUEST['Date_out'];
    $Quantity = $_REQUEST['Quantity'];
    $Markup = $_REQUEST['Markup'];
    $Sgl = $_REQUEST['Sgl'];
    $Dbl = $_REQUEST['Dbl'];
    $Twn = $_REQUEST['Twn'];
    $Tpl = $_REQUEST['Tpl'];
    $Spc_rq = $_REQUEST['Spc_rq'];

    $TotalSgl_USD = ($row_Cost->Cost2_USD * $Quantity * $Sgl) +
    ($row_Cost->Cost2_MMK * $Quantity * $Sgl / $row_Bookings->Exchange);

    $TotalSgl_MMK = ($row_Cost->Cost2_USD * $Quantity * $Sgl * $row_Bookings->Exchange) +
    ($row_Cost->Cost2_MMK * $Quantity * $Sgl);

    $TotalDbl_USD = ($row_Cost->Cost1_USD * $Quantity * $Dbl) +
    ($row_Cost->Cost1_MMK * $Quantity * $Dbl / $row_Bookings->Exchange);

    $TotalDbl_MMK = ($row_Cost->Cost1_USD * $Quantity * $Dbl * $row_Bookings->Exchange) +
    ($row_Cost->Cost1_MMK * $Quantity * $Dbl);

    $TotalTwn_USD = ($row_Cost->Cost1_USD * $Quantity * $Twn) +
    ($row_Cost->Cost1_MMK * $Quantity * $Twn / $row_Bookings->Exchange);

    $TotalTwn_MMK = ($row_Cost->Cost1_USD * $Quantity * $Twn * $row_Bookings->Exchange) +
    ($row_Cost->Cost1_MMK * $Quantity * $Twn / $row_Bookings->Exchange);

    // $TotalTpl_USD = TODO
}
?>

<section>
    <form class="form addingService AC" action="#" method="post">
        <h3 style="text-align: center;">
        <?php echo $row_Cost->SupplierName.": ". $row_Cost->Service; ?>
        </h3>
        <ul>
            <li>
                Check-in:
                <input type="date" name="Date_in" value="<?php echo $Date_in;?>">
            </li>
            <li>
                Check-out:
                <input type="date" name="Date_out" value="<?php echo $Date_out;?>">
            </li>
            <li>
                Night(s):
                <input type="number" name="Quantity" value="<?php echo $Quantity;?>">
            </li>
            <li>
                Markup %:
                <input type="number" step="0.01" name="Markup" value="<?php echo $Markup;?>">
            </li>
            <li style="text-decoration: underline; text-align: center;">
                Rooming
            </li>
            <li>
                Number of Single Room(s):
                <input type="number" name="Sgl" value="<?php echo $Sgl;?>">
            </li>
            <li>
                Number of Double Room(s):
                <input type="number" name="Dbl" value="<?php echo $Dbl;?>">
            </li>
            <li>
                Number of Twin Room(s):
                <input type="number" name="Twn" value="<?php echo $Twn;?>">
            </li>
            <li>
                Number of Triple Room(s):
                <input type="number" name="Tpl" value="<?php echo $Tpl;?>">
            </li>
            <li>
                Special Request:
                <input type="text" name="Spc_rq" value="<?php echo $Spc_rq; ?>" placeholder="Special Request for Supplier">
            </li>
            <li>
                <button type="submit" name="buttonSubmit">Submit</button>
            </li>
        </ul>
    </form>
</section>
