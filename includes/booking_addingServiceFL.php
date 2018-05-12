<section>
    <form class="form addingService FL" action="#" method="post">
        <h3 style="text-align: center">
            <?php echo $row_Cost->SupplierName; ?>
        </h3>
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
                <input type="number" name="Pax" value="<?php echo $Pax;?>" readonly>
            </li>
            <li>
                Cost in USD / pers: &nbsp;
                <input type="number" step="0.01" name="Cost1_USD">&nbsp;
                Sell in USD / pers: &nbsp;
                <input type="number" step="0.01" name="USD" value="">
            </li>
            <li>
                Cost in MMK / pers:&nbsp;
                <input type="number" name="Cost1_MMK" value="">&nbsp;
                Sell in MMK / pers: &nbsp;
                <input type="number" name="MMK" value="">
            </li>
        </ul>
    </form>
</section>
