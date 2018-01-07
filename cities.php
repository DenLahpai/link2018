<?php
require "functions.php";

//Insert data to the table Cities
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AirportCode = $_REQUEST['AirportCode'];
    $City = trim($_REQUEST['City']);
    $CountryCode = $_REQUEST['CountryCode'];
    if(empty($AirportCode) || empty($City) || empty($CountryCode)) {
        $msg_error = $empty_field;
    }
    else {
        //checking for duplications
        $check_Cities = new Database();
        $query_check_Cities = "SELECT * FROM Cities WHERE AirportCode = :AirportCode ;";
        $check_Cities->query($query_check_Cities);
        $check_Cities->bind(':AirportCode', $AirportCode);
        $rowCount_Cities = $check_Cities->rowCount();
        if ($rowCount_Cities > 0) {
            $msg_error = $duplicate_entry;
        }
        else {
            //inserting
            $insert_Cities = new Database();
            $query_insert_Cities = "INSERT INTO Cities (
                AirportCode,
                City,
                CountryCode
                ) VALUES(
                :AirportCode,
                :City,
                :CountryCode
                )
            ;";
            $insert_Cities->query($query_insert_Cities);
            $insert_Cities->bind(':AirportCode', $AirportCode);
            $insert_Cities->bind(':City', $City);
            $insert_Cities->bind(':CountryCode', $CountryCode);
            if($insert_Cities->execute()) {
                $msg_error = NULL;
            }
            else {
                $msg_error = $connection_problem;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "Cities";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Cities";
            include "includes/nav.html";
            include "includes/header.html";
            ?>
            <section>
                <form class="form cities" id="form_cities" action="#" method="post">
                    <ul>
                        <li>
                            <label for="AirportCode">Airport Code:</label>
                            <input type="text" name="AirportCode" id="AirportCode"
                            size="3" maxlength="3" required>
                        </li>
                        <li>
                            <label for="City">City:</label>
                            <input type="text" name="City" id="City" placeholder="City Name" required>
                        </li>
                        <li>
                            <label for="CountryCode">Country:</label>
                            <select name="CountryCode"> -->
                                <option value="">Select</option>
                                <?php
                                //getting data from the table Countries
                                $getRows_Countries = new Database();
                                $query_getRows_Countries = "SELECT * FROM Countries ORDER BY Country;";
                                $getRows_Countries->query($query_getRows_Countries);
                                $rows_Countries = $getRows_Countries->resultset();
                                foreach ($rows_Countries as $row_Countries) {
                                    echo "<option value=\"$row_Countries->Code\">".$row_Countries->Country."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //getting data from the table Cities
                        $getRows_Cities = new Database();
                        $query_getRows_Cities = "SELECT
                            Cities.Id,
                            Cities.AirportCode,
                            Cities.City,
                            Countries.Country AS Country
                            FROM Cities, Countries
                            WHERE Cities.CountryCode = Countries.Code
                            ORDER BY City ;";
                        $getRows_Cities->query($query_getRows_Cities);
                        $rows_Cities = $getRows_Cities->resultset();
                        foreach ($rows_Cities as $row_Cities) {
                            echo "<tr>";
                            echo "<td>".$row_Cities->AirportCode."</td>";
                            echo "<td>".$row_Cities->City."</td>";
                            echo "<td>".$row_Cities->Country."</td>";
                            echo "<td><a href=\"citiesEdit.php?CitiesId=$row_Cities->Id\">";
                            echo "Edit</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
