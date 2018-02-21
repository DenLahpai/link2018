<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServiceTypeId = '2';
    $SupplierId = $_REQUEST['SupplierId'];
    $Service = 'Manual Entry';
    $StartDate = $_REQUEST['StartDate'];
    $EndDate = $_REQUEST['EndDate'];
    $MaxPax = '1';

    //checking for empty field
    if ($SupplierId == "" || $SupplierId == NULL || $SupplierId < 1) {
        $msg_error = $empty_field;
    }
    else {
        //checking for duplication
        $check_Cost = new Database();
        $query_check_Cost = "SELECT Id FROM Cost
            WHERE SupplierId = :SupplierId
            AND Service = :Service
            AND StartDate = :StartDate
            AND EndDate = :EndDate
        ;";
        $check_Cost->query($query_check_Cost);
        $check_Cost->bind(':SupplierId', $SupplierId);
        $check_Cost->bind(':Service', $Service);
        $check_Cost->bind(':StartDate', $StartDate);
        $check_Cost->bind(':EndDate', $EndDate);
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
                StartDate,
                EndDate,
                MaxPax
                ) VALUES (
                :ServiceTypeId,
                :SupplierId,
                :Service,
                :StartDate,
                :EndDate,
                :MaxPax
                )
            ;";
            $insert_Cost->query($query_insert_Cost);
            $insert_Cost->bind(':ServiceTypeId', $ServiceTypeId);
            $insert_Cost->bind(':SupplierId', $SupplierId);
            $insert_Cost->bind(':Service', $Service);
            $insert_Cost->bind(':StartDate', $StartDate);
            $insert_Cost->bind(':EndDate', $EndDate);
            $insert_Cost->bind(':MaxPax', $MaxPax);
            $insert_Cost->execute();
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = 'Flight';
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Service: Flight";
            include "includes/header.html";
            include "includes/nav.html"
            ?>
            <section>
                <form class="form serviceFl" action="#" method="post">
                    <ul>
                        <li>
                            <label for="SupplierId">Airline:</label>
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
                            <label for="StartDate">Valid From:</label>
                            <input type="date" name="StartDate" id="StartDate">
                        </li>
                        <li>
                            <label for="EndDate">Valid Until:</label>
                            <input type="date" name="EndDate" id="EndDate">
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
                    $rows_Cost = getRows_Cost('2', NULL);
                    foreach ($rows_Cost as $row_Cost) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<ul>";
                        echo "<li>".$row_Cost->SupplierName."</li>";
                        echo "<li>".$row_Cost->Service."</li>";
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
