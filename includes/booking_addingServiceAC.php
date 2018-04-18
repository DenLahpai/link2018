<?php
$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {
    $SupplierName = $row_Cost->SupplierName;
}
?>

<section>
    <form class="form addingService AC" action="#" method="post">
        <ul>
            <li>
                <?php echo $SupplierName.": ". $row_Cost->Service; ?>
            </li>
            <li style="text-decoration: underline; text-align: center;">Rooming</li>
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
        </ul>
    </form>
</section>
