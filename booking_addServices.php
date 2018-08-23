<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $rows_Suppliers = filter_rows_Suppliers($ServiceTypeId);
}

if (isset($_REQUEST['buttonSubmit'])) {
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $SupplierId = $_REQUEST['SupplierId'];
    $Date_in = $_REQUEST['Date_in'];
    $Quantity = $_REQUEST['Quantity'];
    $Markup = $_REQUEST['Markup'];
    $rows_Service = searchServices();
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Add Service: ";
    $title .= $Reference;
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Services: ".$Reference;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <section>
                <form class="form addService" action="#" method="post" id="form1">
                    <h3 style="text-align: center;">Add Service</h3>
                    <ul>
                        <li>
                            Service Type:
                            <select name="ServiceTypeId" onchange="this.form.submit()">
                                <option value="0">Select One</option>
                                <?php
                                $rows_ServiceType = getRows_ServiceType(NULL);
                                foreach ($rows_ServiceType as $row_ServiceType) {
                                    if($ServiceTypeId == $row_ServiceType->Id) {
                                        echo "<option value=\"$row_ServiceType->Id\" selected>".$row_ServiceType->Type."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_ServiceType->Id\">".$row_ServiceType->Type."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Suppliers:
                            <select name="SupplierId">
                                <?php
                                if (!empty($ServiceTypeId)) {
                                    foreach ($rows_Suppliers as $row_Suppliers) {
                                        if ($SupplierId == $row_Suppliers->SupplierId) {
                                            echo "<option value=\"$row_Suppliers->SupplierId\" selected>";
                                            echo $row_Suppliers->SupplierName."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Suppliers->SupplierId\">";
                                            echo $row_Suppliers->SupplierName."</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Service Date:
                            <input type="date" name="Date_in" value="<?php echo $Date_in; ?>">
                        </li>
                        <li>
                            Qty / Night(s):
                            <input type="number" name="Quantity" value="<?php echo $Quantity; ?>">
                        </li>
                        <li>
                            Markup (%):
                            <input type="number" step="0.01" name="Markup" value="<?php echo $Markup; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Search</button>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    if (!empty($rows_Service)) {
                        foreach ($rows_Service as $row_Service) {
                            echo "<div class=\"grid-item\">";
                            echo "<form action=\"booking_addingService.php?BookingsId=$BookingsId&CostId=$row_Service->Id\" method=\"post\"  id=\"secondForm$row_Service->Id\">";
                            echo "<ul>";
                            echo "<li class=\"hidden\"><input type=\"date\" name=\"Date_in\" id=\"Date_in\" value=\"$Date_in\"></li>";
                            echo "<li class=\"hidden\"><input type=\"number\" name=\"Quantity\" id=\"Quantity\" value=\"$Quantity\"></li>";
                            echo "<li class=\"hidden\"><input type=\"number\" name=\"Markup\" id=\"Markup\" value=\"$Markup\"></li>";
                            echo "<li class=\"hidden\"><input type=\"number\" name=\"CostId\"  id=\"CostId\" value=\"$row_Service->Id\"></li>";
                            echo "<li>".$row_Service->SuppliersName."</li>";
                            echo "<li>".$row_Service->Service."</li>";
                            echo "<li>".$row_Service->Additional."</li>";
                            echo "<li>";
                            echo "<button type=\"submit\" name=\"buttonAdd\">Add</button></li>";
                            echo "</ul>";
                            echo "</form>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div><!-- end of grid-div -->
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html";?>
    </body>    
</html>
