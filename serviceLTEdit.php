<?php
require "functions.php";
//getting CostId
$CostId = trim($_REQUEST['CostId']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $SupplierId = $_REQUEST['SupplierId'];
    $Service = trim($_REQUEST['Service']);
    $Additional = trim($_REQUEST['Additional']);
    $StartDate = $_REQUEST['StartDate'];
    $EndDate = $_REQUEST['EndDate'];
    $MaxPax = $_REQUEST['MaxPax'];
    $Cost1_USD = $_REQUEST['Cost1_USD'];
    $Cost1_MMK = $_REQUEST['Cost1_MMK'];

    $update_Cost = new Database();
    $query_update_Cost = "UPDATE Cost SET
        SupplierId = :SupplierId,
        Service = :Service,
        Additional = :Additional,
        StartDate = :StartDate,
        EndDate = :EndDate,
        MaxPax = :MaxPax,
        Cost1_USD = :Cost1_USD,
        Cost1_MMK = :Cost1_MMK
        WHERE Id = :CostId
    ;";
    $update_Cost->query($query_update_Cost);
    $update_Cost->bind(':SupplierId', $SupplierId);
    $update_Cost->bind(':Service', $Service);
    $update_Cost->bind(':Additional', $Additional);
    $update_Cost->bind(':StartDate', $StartDate);
    $update_Cost->bind(':EndDate', $EndDate);
    $update_Cost->bind(':MaxPax', $MaxPax);
    $update_Cost->bind(':Cost1_USD', $Cost1_USD);
    $update_Cost->bind(':Cost1_MMK', $Cost1_MMK);
    $update_Cost->bind(':CostId', $CostId);
    $update_Cost->execute();
}

//getting data from the table Cost
$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {

}
?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Edit Service";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Service";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form ServiceLT" action="#" method="post">
                    <ul>
                        <li>
                            <label for="SupplierId">Supplier:</label>
                            <select id="SupplierId" name="SupplierId">
                                <option value="">Select</option>
                                <?php
                                $rows_Suppliers = getRows_Suppliers($row_Cost->SupplierId);
                                foreach ($rows_Suppliers as $row_Suppliers) {
                                    if($row_Suppliers->Id == $row_Cost->SupplierId) {
                                        echo "<option value=\"$row_Suppliers->Id\" selected>$row_Suppliers->Name</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_Suppliers->Id\">$row_Suppliers->Name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="Service">Service:</label>
                            <input type="text" name="Service" id="Service"
                            value="<?php echo $row_Cost->Service; ?>" required>
                        </li>
                        <li>
                            <label for="Additional">Additional:</label>
                            <input type="text" name="Additional" id="Additional"
                            value="<?php echo $row_Cost->Additional; ?>">
                        </li>
                        <li>
                            <label for="StartDate">Valid From:</label>
                            <input type="date" name="StartDate" id="StartDate"
                            required value="<?php echo $row_Cost->StartDate; ?>">
                        </li>
                        <li>
                            <label for="EndDate">Valid Until:</label>
                            <input type="date" name="EndDate" id="EndDate" required
                            value="<?php echo $row_Cost->EndDate; ?>">
                        </li>
                        <li>
                            <label for="MaxPax">Maximum Pax:</label>
                            <input type="number" name="MaxPax" id="MaxPax" min="1"
                            value="<?php echo $row_Cost->MaxPax; ?>">
                        </li>
                        <li>
                            <label for="Cost1_USD">Cost in USD:</label>
                            <input type="number" name="Cost1_USD" id="Cost1_USD" step="0.01"
                            value="<?php echo $row_Cost->Cost1_USD; ?>">
                        </li>
                        <li>
                            <label for="Cost1_MMK">Cost in MMK:</label>
                            <input type="number" name="Cost1_MMK" id="Cost1_MMK"
                            value=<?php echo $row_Cost->Cost1_MMK; ?>>
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
