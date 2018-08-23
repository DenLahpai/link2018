<?php
require_once "functions.php";
$search = NULL;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CorporatesId = $_REQUEST['CorporatesId'];
    $SuppliersId = $_REQUEST['SuppliersId'];
    $Date_in1 = $_REQUEST['Date_in1'];
    $Date_in2 = $_REQUEST['Date_in2'];
    if ($Date_in2 == NULL) {
        $Date_in2 = $Date_in1;
    }
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $search = trim($_REQUEST['search']);
    // $rows_Services = get_report_Services_booking();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $title = "Serivces Report";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Services Report";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form report services" action="#" method="post">
                    <ul>
                        <li style="font-weight: bold; text-align: center;">
                            Enter Search Criteria
                        </li>
                        <li>
                            <label for="CorporatesId">Corporates:</label>
                            <select id="CorporatesId" name="CorporatesId">
                                <option value="">Select One</option>
                                <?php
                                $rows_Corporates = getRows_Corporates();
                                foreach ($rows_Corporates as $row_Corporates) {
                                    if ($row_Corporates->Id == $CorporatesId) {
                                        echo "<option value=\"$row_Corporates->Id\" selected>$row_Corporates->Name</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_Corporates->Id\">$row_Corporates->Name</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label for="SuppliersId">Suppliers:</label>
                            <select id="SuppliersId" name="SuppliersId">
                                <option value="">Select One</option>
                                <?php
                                $rows_Suppliers = getRows_Suppliers($SupplierId);
                                foreach ($rows_Suppliers as $row_Suppliers) {
                                    if ($row_Suppliers->Id == $SuppliersId) {
                                        echo "<option value=\"$row_Suppliers->Id\" selected>".$row_Suppliers->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_Suppliers->Id\">".$row_Suppliers->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="Date_in1">Service Date From:</label>
                            <input type="date" name="Date_in1" value="<?php echo $Date_in1; ?>">
                            <label for="Date_in2">Until</label>
                            <input type="date" name="Date_in2" value="<?php echo $Date_in2; ?>">
                        </li>
                        <li>
                            <label for="ServiceTypeId">Service Type:</label>
                            <select id="ServceiTypeId" name="ServiceTypeId">
                                <option value="">Select One</option>
                                <?php
                                $rows_ServiceType = getRows_ServiceType(NULL);
                                foreach ($rows_ServiceType as $row_ServiceType) {
                                    if ($row_ServiceType->Id == $ServiceTypeId) {
                                        echo "<option value=\"$row_ServiceType->Id\" selected>".$row_ServiceType->Type."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_ServiceType->Id\">".$row_ServiceType->Type."</option>";
                                    }
                                }
                                ?>
                            </select>
                            &nbsp;
                            <input type="text" name="search" placeholder="Search" value="<?php echo $search; ?>">
                        </li>
                        <li style="text-align: center;">
                            <button type="submit" name="buttonSearch">Search</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
