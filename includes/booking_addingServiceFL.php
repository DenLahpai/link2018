<section>
    <form class="form addingService FL" action="#" method="post">
        <h3 style="text-align: center">
            <?php echo $row_Cost->SupplierName; ?>
        </h3>
        <ul>
            <li>
                From:
                <select name="Pick_up">
                    <option value="">Select</option>
                    <?php
                    $rows_Cities->getRows_Cities(NULL);
                    ?>
                </select>
            </li>
        </ul>
    </form>
</section>
