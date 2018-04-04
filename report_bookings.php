
<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CorporatesId = $_REQUEST['CorporatesId'];
    $Status = $_REQUEST['Status'];
    $ArvDate1 = $_REQUEST['ArvDate1'];
    $ArvDate2 = $_REQUEST['ArvDate2'];
    $created1 = $_REQUEST['created1'];
    $created2 = $_REQUEST['created2'];
    $rows_bookings = get_report_bookings();
    //TODO write functions to get report in functions.php
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Bookings Report";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Bookings Report";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form report bookings" action="#" method="post">
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
                                    if($row_Corporates->Id == $CorporatesId) {
                                        echo "<option value=\"$row_Corporates->Id\" selected>$row_Corporates->Name</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_Corporates->Id\">$row_Corporates->Name</option>";
                                    }
                                }
                                ?>
                            </select>
                            Status:
                            <select name="Status">
                                <?php
                                switch ($Status) {
                                    case 'Confirmed':
                                        echo "<option value=\"Confirmed\" selected>Confirmed</option>";
                                        echo "<option value=\"Cancelled\">Cancelled</option>";
                                        echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                        break;
                                    case 'Not Confirmed':
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Not Confirmed\" selected>Not Confirmed</option>";
                                        echo "<option value=\"Cancelled\">Cancelled</option>";
                                        break;
                                    case 'Cancelled':
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                        echo "<option value=\"Cancelled\" selected>Cancelled</option>";
                                        break;
                                    default:
                                        echo "<option value=\"\">Select One</option>";
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Cancelled\">Cancelled</option>";
                                        echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                        break;
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Arrival Date From:
                            <input type="date" name="ArvDate1" value="<?php echo $ArvDate1; ?>">
                            Until:
                            <input type="date" name="ArvDate2" value="<?php echo $ArvDate2; ?>">
                        </li>
                        <li>
                            Create Date From:
                            <input type="date" name="created1" value="<?php echo $created1; ?>">
                            Until:
                            <input type="date" name="created2" value="<?php echo $created2; ?>">
                        </li>
                        <li>
                            <input type="text" name="search" placeholder="Search" value="<?php echo $search; ?>">
                        </li>
                        <li style="text-align: center;">
                            <button type="submit" name="buttonSearch">Search</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
