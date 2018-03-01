<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServiceTypeId = '3';
    $SupplierId = $_REQUEST['SupplierId'];
    $Service = trim($_REQUEST['Service']);
    $Additional = trim($_REQUEST['Additional']);
    $StartDate = $_REQUEST['StartDate'];
    $EndDate = $_REQUEST['EndDate'];
    $MaxPax = $_REQUEST['$MaxPax'];
    $Cost1_USD = $_REQUEST['Cost1_USD'];
    $Cost1_MMK = $_REQUEST['Cost1_MMK'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "Service: Land Transfers";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Service: Land Transfers";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form ServiceTP" action="#" method="post">
                    <ul>
                        <li>
                            <label for="SupplierId">Supplier:</label>
                            <select id="SupplierId" name="SupplierId">
                                <option value="">Select</option>
                                <?php
                                $rows_Suppliers = getRows_Suppliers(NULL);
                                foreach ($rows_Suppliers as $row_Suppliers) {
                                    echo "<option value=\"$row_Suppliers->Id\">
                                    $row_Suppliers->Name</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="Service">Service:</label>
                            <input type="text" name="Service" id="Service"
                            placeholder="Service" required>
                        </li>
                        <li>
                            <label for="Additional">Additional:</label>
                            <input type="text" name="Additional" id="Additional"
                            placeholder="Additional Description">
                        </li>
                        <li>
                            <label for="StartDate">Valid From:</label>
                            <input type="date" name="StartDate" id="StartDate" required>
                        </li>
                        <li>
                            <label for="EndDate">Valid Until:</label>
                            <input type="date" name="EndDate" id="EndDate" required>
                        </li>
                        <li>
                            <label for="MaxPax">Maximum Pax:</label>
                            <input type="number" name="MaxPax" id="MaxPax" value="2" min="1">
                        </li>
                        <li>
                            <label for="Cost1_USD">Cost in USD:</label>
                            <input type="number" name="Cost1_USD" id="Cost1_USD" step="0.01">
                        </li>
                        <li>
                            <label for="Cost1_MMK">Cost in MMK:</label>
                            <input type="number" name="Cost1_MMK" id="Cost1_MMK">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    $rows_Cost = getRows_Cost('3', NULL);
                    foreach ($rows_Cost as $row_Cost) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<ul>";
                        echo "<li>".$row_Cost->SupplierName."</li>";
                        echo "<li>".$row_Cost->Service." ";
                        echo $row_Cost->Additional."</li>";
                        echo "<li>".date("d-M-Y", strtotime($row_Cost->StartDate));
                        echo " Until ".date("d-M-Y", strtotime($row_Cost->EndDate))."</li>";
                        echo "<li><a href=\"serviceACEdit.php?CostId=$row_Cost->Id\">Edit</a></li>";
                        echo "</ul></div><!-- end of grid-item -->";
                    }
                    ?>
                </div><!-- end of grid-div -->
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
