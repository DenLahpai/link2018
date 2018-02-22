<?php
require "functions.php";
//getting CostId
$CostId = trim($_REQUEST['CostId']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $SupplierId = $_REQUEST['SupplierId'];
    $StartDate = $_REQUEST['StartDate'];
    $EndDate = $_REQUEST['EndDate'];

    //TODO GERE
}


//getting data from the table Cost
$rows_Cost = getRows_Cost(NULL, $CostId);
foreach ($rows_Cost as $row_Cost) {

}
?>
<!DOCTYPE html>
<html>
    <?php
    $title = 'Edit Service';
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
                <form class="form ServiceFL" action="#" method="post">
                    <ul>
                        <li>
                            <label for="SupplierId">Airline:</label>
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
                            <label for="StartDate">Valid From:</label>
                            <input type="date" name="StartDate" id="StartDate" value="<?php echo $row_Cost->StartDate; ?>">
                        </li>
                        <li>
                            <label for="EndDate">Valid Until:</label>
                            <input type="date" name="EndDate" id="EndDate" value="<?php echo $row_Cost->EndDate; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
    </body>
</html>
