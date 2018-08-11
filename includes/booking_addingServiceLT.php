<?php
$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {
    $ServiceTypeId = $row_Cost->ServiceTypeId;
    $SupplierId = $row_Cost->SupplierId;
    $Cost1_MMK = $row_Cost->Cost1_MMK;
    $Cost1_USD = $row_Cost->Cost1_USD;
}

if (isset($_REQUEST['buttonSubmit'])) {
    $Date_in = $_REQUEST['Date_in'];
    $Pick_up = trim($_REQUEST['Pick_up']);
    $Pick_up_time = $_REQUEST['Pick_up_time'];
    $Drop_off = trim($_REQUEST['Drop_off']);
    $Drop_off_time = $_REQUEST['Drop_off_time'];
    if ($_REQUEST['Quantity'] == NULL || $_REQUEST['Quantity'] == "" || empty($_REQUEST['Quantity'])) {
        $Quantity = 1;
    }
    else {
        $Quantity = $_REQUEST['Quantity'];
    }

    if ($_REQUEST['Markup'] == NULL || $_REQUEST['Markup'] == "" || empty($_REQUEST['Markup'])) {
        $Markup = 0;
    }
    else {
        $Markup = $_REQUEST['Markup'];
    }

    $Total_cost_MMK = $Cost1_MMK * $Quantity;
    $Total_cost_USD = $Cost1_USD * $Quantity;

    $Sell_MMK = round($Total_cost_MMK + ($Total_cost_MMK * $Markup / 100),2);
    $Sell_USD = round($Total_cost_USD + ($Total_cost_USD * $Markup / 100), 2);

    $database = new Database();
    $queryInsert = "INSERT INTO Services_booking (
        BookingsId,
        CostId,
        Date_in,
        Pax,
        Quantity,
        Pick_up,
        Drop_off,
        Pick_up_time,
        Drop_off_time,
        Cost1_USD,
        Cost1_MMK,
        Total_cost_USD,
        Total_cost_MMK,
        Markup,
        Sell_USD,
        Sell_MMK
        ) VALUES(
        :BookingsId,
        :CostId,
        :Date_in,
        :Pax,
        :Quantity,
        :Pick_up,
        :Drop_off,
        :Pick_up_time,
        :Drop_off_time,
        :Cost1_USD,
        :Cost1_MMK,
        :Total_cost_USD,
        :Total_cost_MMK,
        :Markup,
        :Sell_USD,
        :Sell_MMK
        )
    ;";
    $database->query($queryInsert);
    $database->bind(':BookingsId', $BookingsId);
    $database->bind(':CostId', $CostId);
    $database->bind(':Date_in', $Date_in);
    $database->bind(':Pax', $Pax);
    $database->bind(':Quantity', $Quantity);
    $database->bind(':Pick_up', $Pick_up);
    $database->bind(':Drop_off', $Drop_off);
    $database->bind(':Pick_up_time', $Pick_up_time);
    $database->bind(':Drop_off_time', $Drop_off_time);
    $database->bind(':Cost1_USD', $Cost1_USD);
    $database->bind(':Cost1_MMK', $Cost1_MMK);
    $database->bind(':Total_cost_USD', $Total_cost_USD);
    $database->bind(':Total_cost_MMK', $Total_cost_MMK);
    $database->bind(':Markup', $Markup);
    $database->bind(':Sell_USD', $Sell_USD);
    $database->bind(':Sell_MMK', $Sell_MMK);
    if ($database->execute()) {
        header("location: booking_services.php?BookingsId=$BookingsId");
    }
}
?>
<section>
    <form class="form addingService LT" action="#" method="post">
        <ul>
            <li>
                Date:
                <input type="date" name="Date_in" value="<?php echo $Date_in; ?>">
            </li>
            <li>
                Pick_up:
                <input type="text" name="Pick_up">
                &nbsp;
                Pick_up Time:
                <input type="time" name="Pick_up_time" >
            </li>
            <li>
                Drop_off:
                <input type="text" name="Drop_off">
                &nbsp;
                Drop_off Time:
                <input type="time" name="Drop_off_time" value="">
            </li>
            <li>
                Quantity:
                <input type="text" name="Quantity" value="<?php echo $Quantity; ?>">
                &nbsp;
                Mark-up %:
                <input type="text" name="Markup" step="0.01" value="<?php echo $Markup; ?>">
            </li>
            <li>
                <button type="submit" name="buttonSubmit">Submit</button>
            </li>
        </ul>
    </form>
</section>
