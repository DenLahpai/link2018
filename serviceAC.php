<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServiceTypeId = '1';
    $SupplierId = $_REQUEST['SupplierId'];
    $Service = trim($_REQUEST['Service']);
    $Additional = trim($_REQUEST['Additional']);
    $StartDate = $_REQUEST['StartDate'];
    $EndDate = $_REQUEST['EndDate'];
    $MaxPax = $_REQUEST['MaxPax'];
    $Cost1_USD = $_REQUEST['Cost1_USD'];
    $Cost1_MMK = $_REQUEST['Cost1_MMK'];
    $Cost2_USD = $_REQUEST['Cost2_USD'];
    $Cost2_MMK = $_REQUEST['Cost2_MMK'];
    $Cost3_USD = $_REQUEST['Cost3_USD'];
    $Cost3_MMK = $_REQUEST['Cost3_MMK'];

    //checking for empty fields
    if ($SupplierId == "" || $SupplierId == NULL || $SupplierId < 1) {
        $msg_error = $empty_field;
    }
    else {
        $check_Cost = new Database();

        $query_check_Cost = "SELECT Id FROM Cost
            WHERE SupplierId = :SupplierId
            AND Service = :Service
            AND Additional = :Additional
            AND StartDate = :StartDate
            AND EndDate = :EndDate
            AND Cost1_USD = :Cost1_USD
            AND Cost1_MMK = :Cost1_MMK
        ;";
        $check_Cost->query($query_check_Cost);
        $check_Cost->bind(':SupplierId', $SupplierId);
        $check_Cost->bind(':Service', $Service);
        $check_Cost->bind(':Additional', $Additional);
        $check_Cost->bind(':StartDate', $StartDate);
        $check_Cost->bind(':EndDate', $EndDate);
        $check_Cost->bind(':Cost1_USD', $Cost1_USD);
        $check_Cost->bind(':Cost1_MMK', $Cost1_MMK);
        $rowCount_Cost = $check_Cost->rowCount();
        if($rowCount_Cost > 0) {
            $msg_error = $duplicate_entry;
        }
        else {
            $insert_Cost = new Database();
            $query_insert_Cost = "INSERT INTO Cost (
                ServiceTypeId,
                SupplierId,
                Service,
                Additional,
                StartDate,
                EndDate,
                MaxPax,
                Cost1_USD,
                Cost1_MMK,
                Cost2_USD,
                Cost2_MMK,
                Cost3_USD,
                Cost3_MMK
                ) VALUES (
                :ServiceTypeId,
                :SupplierId,
                :Service,
                :Additional,
                :StartDate,
                :EndDate,
                :MaxPax,
                :Cost1_USD,
                :Cost1_MMK,
                :Cost2_USD,
                :Cost2_MMK,
                :Cost3_USD,
                :Cost3_MMK
                )
            ;";
            $insert_Cost->query($query_insert_Cost);
            $insert_Cost->bind(':ServiceTypeId', $ServiceTypeId         );
            $insert_Cost->bind(':SupplierId', $SupplierId);
            $insert_Cost->bind(':Service', $Service);
            $insert_Cost->bind(':Additional', $Additional);
            $insert_Cost->bind(':StartDate', $StartDate);
            $insert_Cost->bind(':EndDate', $EndDate);
            $insert_Cost->bind(':MaxPax', $MaxPax);
            $insert_Cost->bind(':Cost1_USD', $Cost1_USD);
            $insert_Cost->bind(':Cost1_MMK', $Cost1_MMK);
            $insert_Cost->bind(':Cost2_USD', $Cost2_USD);
            $insert_Cost->bind(':Cost2_MMK', $Cost2_MMK);
            $insert_Cost->bind(':Cost3_USD', $Cost3_USD);
            $insert_Cost->bind(':Cost3_MMK', $Cost3_MMK);

            if($insert_Cost->execute()) {
                $msg_error = NULL;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Accommodation";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Service: Accommodation";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form ServiceAC" action="#" method="post">
                    <ul>
                        <li>
                            <label for="SupplierId">Supplier:</label>
                            <select id="SupplierId" name="SupplierId">
                                <option value="">Select</option>
                                <?php
                                $rows_Suppliers = getRows_Suppliers(NULL);
                                foreach ($rows_Suppliers as $row_Suppliers) {
                                    echo "<option value=\"$row_Suppliers->Id\">$row_Suppliers->Name</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="Service">Service:</label>
                            <input type="text" name="Service" id="Service" placeholder="Room Type" required>
                        </li>
                        <li>
                            <label for="Additional">Additional:</label>
                            <input type="text" name="Additional" id="Additional" placeholder="Additional Description">
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
                            <label for="Cost1_USD">Cost in USD (Twin or Double):</label>
                            <input type="number" name="Cost1_USD" id="Cost1_USD" step="0.01">
                        </li>
                        <li>
                            <label for="Cost1_MMK">Cost in MMK (Twin or Double):</label>
                            <input type="number" name="Cost1_MMK" id="Cost1_MMK">
                        </li>
                        <li>
                            <label for="Cost2_USD">Cost in USD (Single):</label>
                            <input type="number" name="Cost2_USD" id="Cost2_USD" step="0.01">
                        </li>
                        <li>
                            <label for="Cost2_MMK">Cost in MMK (Single):</label>
                            <input type="number" name="Cost2_MMK" id="Cost2_MMK">
                        </li>
                        <li>
                            <label for="Cost3_USD">Cost in USD (Triple):</label>
                            <input type="number" name="Cost3_USD" id="Cost3_USD" step="0.01">
                        </li>
                        <li>
                            <label for="Cost3_MMK">Cost in MMK (Triple):</label>
                            <input type="number" name="Cost3_MMK" id="Cost3_MMK">
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
                    $rows_Cost = getRows_Cost('1', NULL);
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
        </div><!-- endo of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
