<?php
require_once "functions.php";
$search = NULL;
// TODO summitting the form 

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
                            <label for="Status">Status:</label>
                            <select id="Status" name="Status">
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
                            <label for="Date_in1">Service Date From:</label>
                            <input type="date" name="Date_in1" value="<?php echo $Date_in1; ?>">
                            <label for="Date_in2">Until</label>
                            <input type="date" name="Date_in2" value="<?php echo $Date_in2; ?>">
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
        </div>
        <!-- end of content -->
    </body>
</html>
