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
    ($row_Cost->Cost1_MMK * $Quantity * $Twn);

    $TotalTpl_USD = ($row_Cost->Cost3_USD * $Quantity * $Tpl) +
    ($row_Cost->Cost3_MMK * $Quantity * $Tpl / $row_Bookings->Exchange);

    $TotalTpl_MMK = ($row_Cost->Cost3_USD * $Quantity * $Tpl  * $row_Bookings->Exchange) +
    ($row_Cost->Cost3_MMK * $Quantity * $Tpl);

    $Total_USD = round($TotalSgl_USD + $TotalTwn_USD + $TotalDbl_USD + $TotalTpl_USD, 2);
    $Total_MMK = round($TotalSgl_MMK + $TotalTwn_MMK + $TotalDbl_MMK + $TotalTpl_MMK, 2);

    $profit_USD = $Total_USD * $Markup / 100;
    $profit_MMK = $Total_MMK * $Markup / 100;

    $Sell_USD = round($Total_USD + $profit_USD, 2);
    $Sell_MMK = round($Total_MMK + $profit_MMK, 2);

    $database = new Database;
    $queryInsert = "INSERT INTO Services_booking (
        BookingsId,
        CostId,
        Date_in,
        Date_out,
        Pax,
        Sgl,
        Dbl,
        Twn,
        Tpl,
        Quantity,
        Spc_rq,
        Cost1_USD,
        Cost1_MMK,
        Cost2_USD,
        Cost2_MMK,
        Cost3_USD,
        Cost3_MMK,
        Total_cost_USD,
        Total_cost_MMK,
        Markup,
        Sell_USD,
        Sell_MMK
        ) VALUES(
        :BookingsId,
        :CostId,
        :Date_in,
        :Date_out,
        :Pax,
        :Sgl,
        :Dbl,
        :Twn,
        :Tpl,
        :Quantity,
        :Spc_rq,
        :Cost1_USD,
        :Cost1_MMK,
        :Cost2_USD,
        :Cost2_MMK,
        :Cost3_USD,
        :Cost3_MMK,
        :Total_USD,
        :Total_MMK,
        :Markup,
        :Sell_USD,
        :Sell_MMK
        )
    ;";
    $database->query($queryInsert);
    $database->bind(':BookingsId', $BookingsId);
    $database->bind(':CostId', $CostId);
    $database->bind(':Date_in', $Date_in);
    $database->bind(':Date_out', $Date_out);
    $database->bind(':Pax', $row_Bookings->Pax);
    $database->bind(':Sgl', $Sgl);
    $database->bind(':Dbl', $Dbl);
    $database->bind(':Twn', $Twn);
    $database->bind(':Tpl', $Tpl);
    $database->bind(':Quantity', $Quantity);
    $database->bind(':Spc_rq', $Spc_rq);
    $database->bind(':Cost1_USD', $row_Cost->Cost1_USD);
    $database->bind(':Cost1_MMK', $row_Cost->Cost1_MMK);
    $database->bind(':Cost2_USD', $row_Cost->Cost2_USD);
    $database->bind(':Cost2_MMK', $row_Cost->Cost2_MMK);
    $database->bind(':Cost3_USD', $row_Cost->Cost3_USD);
    $database->bind(':Cost3_MMK', $row_Cost->Cost3_MMK);
    $database->bind(':Total_USD', $Total_USD);
    $database->bind(':Total_MMK', $Total_MMK);
    $database->bind(':Markup', $Markup);
    $database->bind(':Sell_USD', $Sell_USD);
    $database->bind(':Sell_MMK', $Sell_MMK);
    if($database->execute()) {
        header("location:booking_services.php?BookingsId=$BookingsId");
    }
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
