<?php
//scripts to insert data to the table booking_services
if (isset($_REQUEST['buttonSubmit'])) {
    $Date_in = $_REQUEST['Date_in'];
    $Pick_up = $_REQUEST['Pick_up'];
    $Drop_off = $_REQUEST['Drop_off'];
    $Flight_no = trim($_REQUEST['Flight_no']);
    $Pax = $_REQUEST['Pax'];
    $Quantity = 1;
    $Pick_up_time = $_REQUEST['Pick_up_time'];
    $Drop_off_time = $_REQUEST['Drop_off_time'];
    $Currency = $_REQUEST['Currency'];

    if ($Currency == 'USD') {
        $Cost1_USD = $_REQUEST['Cost1_USD'];
        $sellUSD = $_REQUEST['sellUSD'];
        $profit = $sellUSD - $Cost1_USD;
        $Markup = ($profit / $Cost1_USD) * 100;
        $Total_cost_USD = $Cost1_USD * $Pax;
        $Sell_USD = $sellUSD * $Pax;
    }
    elseif ($Currency == 'MMK') {
        $Cost1_MMK = $_REQUEST['Cost1_MMK'];
        $sellMMK = $_REQUEST['sellMMK'];
        $profit = $sellMMK - $Cost1_MMK;
        $Markup = ($profit / $Cost1_MMK) * 100;
        $Total_cost_MMK = $Cost1_MMK * $Pax;
        $Sell_MMK = $sellMMK * $Pax;
    }

    $database = new Database();
    $queryInsert = "INSERT INTO Services_booking (
        BookingsId,
        CostId,
        Date_in,
        Pax,
        Quantity,
        Flight_no,
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
        :Flight_no,
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
    $database->bind(':Flight_no', $Flight_no);
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
    if($database->execute()) {
        header("location:booking_services.php?BookingsId=$BookingsId");
    }
}
?>

<section>
    <form class="form addingService FL" action="#" method="post">
        <ul>
            <li>
                Date:
                <input type="date" name="Date_in" value="<?php echo $Date_in;?>">
                &nbsp;
                Airline:
                <?php echo $row_Suppliers->Name;?>
            </li>
            <li>
                From:&nbsp;
                <select name="Pick_up">
                    <option value="">Select</option>
                    <?php
                    $rows_Cities = getRows_Cities(NULL);
                    foreach ($rows_Cities as $row_Cities) {
                        echo "<option value=\"$row_Cities->City\">$row_Cities->City"." - "."$row_Cities->CountryCode</option>";
                    }
                    ?>
                </select>&nbsp;
                To:&nbsp;
                <select name="Drop_off">
                    <option value="">Select</option>
                    <?php
                    $rows_Cities = getRows_Cities(NULL);
                    foreach ($rows_Cities as $row_Cities) {
                        echo "<option value=\"$row_Cities->City\">$row_Cities->City"." - "."$row_Cities->CountryCode</option>";
                    }
                    ?>
                </select>&nbsp;
            </li>
            <li>
                Flight No:&nbsp;
                <input type="text" name="Flight_no" placeholder="Fight No" required>&nbsp;
                Pax:&nbsp;
                <input type="number" name="Pax" value="<?php echo $Pax;?>">
            </li>
            <li>
                ETD:&nbsp;
                <input type="time" name="Pick_up_time">&nbsp;
                ETA:&nbsp;
                <input type="time" name="Drop_off_time">
            </li>
            <li>
                Select Currency:
                <select id="Currency" name="Currency" onchange="selectCurrency();">
                    <option value="">Select One</option>
                    <option value="USD">USD</option>
                    <option value="MMK">MMK</option>
                </select>
            </li>
            <li id="USD" style="display:none">
                Cost in USD / pers: &nbsp;
                <input type="number" step="0.01" name="Cost1_USD">&nbsp;
                Sell in USD / pers: &nbsp;
                <input type="number" step="0.01" name="sellUSD" value="">
            </li>
            <li id="MMK" style="display:none">
                Cost in MMK / pers:&nbsp;
                <input type="number" name="Cost1_MMK" value="">&nbsp;
                Sell in MMK / pers: &nbsp;
                <input type="number" name="sellMMK" value="">
            </li>
            <li>
                <button type="submit" name="buttonSubmit" id="buttonSubmit" style="display: none;">Submit</button>
            </li>
        </ul>
    </form>
</section>
<script type="text/javascript">
    function selectCurrency() {
        var Currency = document.getElementById('Currency').value;
        if (Currency === 'USD') {
            document.getElementById('USD').style.display = 'block';
            document.getElementById('MMK').style.display = 'none';
            document.getElementById('buttonSubmit').style.display = 'block';
        }
        else if (Currency === 'MMK') {
            document.getElementById('USD').style.display = 'none';
            document.getElementById('MMK').style.display = 'block';
            document.getElementById('buttonSubmit').style.display = 'block';
        }
        else {
            document.getElementById('USD').style.display = 'none';
            document.getElementById('MMK').style.display = 'none';
            document.getElementById('buttonSubmit').style.display = 'none';
        }
    }
</script>
