<?php
$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {

}

if(isset($_REQUEST['buttonSubmit'])) {

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
                <input type="number" name="Sgl" value="">
            </li>
            <li>
                Number of Double Room(s):
                <input type="number" name="Dbl" value="">
            </li>
            <li>
                Number of Twin Room(s):
                <input type="number" name="Twn" value="">
            </li>
            <li>
                Number of Triple Room(s):
                <input type="number" name="Tpl" value="">
            </li>
            <li>
                <button type="submit" name="buttonSubmit">Submit</button>
            </li>
        </ul>
    </form>
</section>
<script type="text/javascript">
    function submitForms() {
        var BookingsId = document.getElementById("BookingsId").value;
        var CostId = document.getElementById("CostId").value;
        document.getElementById("form1").action = "booking_addingService.php?BookingsId="+BookingsId+"&CostId="+CostId;
        document.getElementById("form1").submit();
    }
</script>
