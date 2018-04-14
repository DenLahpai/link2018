<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
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
            <section>
                <form class="form addService" action="#" method="post">
                    <h3 style="text-align: center;">Add Service</h3>
                    <ul>
                        <li>
                            Service Type:
                            <select name="ServiceTypeId">
                                <option value="0">Select One</option>
                                <?php
                                $rows_ServiceType = getRows_ServiceType(NULL);
                                foreach ($rows_ServiceType as $row_ServiceType) {
                                    if($ServiceTypeId == $row_ServiceType->Id) {
                                        echo "<option value=\"$row_ServiceType->Id\" selected>".$row_ServiceType->Code."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_ServiceType->Id\">".$row_ServiceType->Code."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
    </body>
</html>
