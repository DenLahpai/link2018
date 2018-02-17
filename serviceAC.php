<?php
require "functions.php";
//TODO codes to insert data to the table Cost 
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
                            <input type="text" name="Service" id="Service" placeholder="Room Type">
                        </li>
                        <li>
                            <label for="Additional">Additional:</label>
                            <input type="text" name="Additional" id="Additional" placeholder="Additional Description">
                        </li>
                        <li>
                            <label for="StartDate">Valid From:</label>
                            <input type="date" name="StartDate" id="StartDate">
                        </li>
                        <li>
                            <label for="EndDate">Valid Until:</label>
                            <input type="date" name="EndDate" id="EndDate">
                        </li>
                        <li>
                            <label for="MaxPax">Maximum Pax:</label>
                            <input type="number" name="MaxPax" id="MaxPax" value="2">
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
                    $rows_Cost = getRows_Cost('AC', NULL);
                    foreach ($rows_Cost as $row_Cost) {
                        echo "<div class=\"grit-item\"><!-- grid-itemv -->";
                        echo "<ul>";
                        echo "<li>".$row_Cost->SupplierName."</li>";
                    }
                    ?>
                </div><!-- end of grid-div -->
            </main>
        </div><!-- endo of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
