<?php
require "conn.php";

//insert data to the table Corporates
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    $Chain = trim($_REQUEST['Chain']);
    $Type = trim($_REQUEST['Type']);
    $CountryCode = $_REQUEST['CountryCode'];
    $Email = $_REQUEST['Email'];
    $Website = $_REQUEST['Website'];

    //checking for empty field(s)
    if(empty($Name) || empty($CountryCode)) {
        $msg_error = $empty_field;
    }
    else {
        //checking for duplications
        $check_Corporates = new Database();
        $query_check_Corporates = "SELECT * FROM Corporates WHERE Name = :Name ;";
        $check_Corporates->query($query_check_Corporates);
        $check_Corporates->bind(':Name', $Name);
        $rowCount_check_Corporates = $check_Corporates->rowCount();
        if($rowCount_check_Corporates > 0) {
            $msg_error = $duplicate_entry;
        }
        else {
            $insert_Corporates = new Database();
            $query_insert_Corporates = "INSERT INTO Corporates(
                Name,
                Chain,
                Type,
                CountryCode,
                Email,
                Website
                ) VALUES(
                :Name,
                :Chain,
                :Type,
                :CountryCode,
                :Email,
                :Website
                )
            ;";
            $insert_Corporates->query($query_insert_Corporates);
            $insert_Corporates->bind(':Name', $Name);
            $insert_Corporates->bind(':Chain', $Chain);
            $insert_Corporates->bind(':Type', $Type);
            $insert_Corporates->bind(':CountryCode', $CountryCode);
            $insert_Corporates->bind(':Email', $Email);
            $insert_Corporates->bind(':Website', $Website);
            if($insert_Corporates->execute()) {
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
        $title = "Corporates";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Corporates";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <form class="form big" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Name">Name:</label>

                            <input type="text" name="Name" id="Name" placeholder="Corporate Name"required>
                        </li>
                        <li>
                            <label for="Chain">Chain:</label>
                            <input type="text" name="Chain" id="Chain" placeholder="Chain Name">
                        </li>
                        <li>
                            <label for="Type">Type:</label>
                            <input type="text" name="Type" id="Type" placeholder="Corporate Type" required>
                        </li>
                        <li>
                            <label for="CountryCode">Country:</label>
                            <select name="CountryCode">
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
                            <label for="Email">Email:</label>
                            <input type="Email" name="Email" id="Email" placeholder="Corporate Email">
                        </li>
                        <li>
                            <label for="Website">Website:</label>
                            <input type="text" name="Website" id="Website" placeholder="Website">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Save</button>
                        </li>
                    </ul>
                </form>
                <div class="grid-div">
                    <?php
                    $getRows_Corporates = new Database();
                    $query_getRows_Corporates = "SELECT
                        Corporates.Id,
                        Corporates.Name,
                        Corporates.Chain,
                        Corporates.Type,
                        Countries.Country,
                        Corporates.Email,
                        Corporates.Website
                        FROM Corporates, Countries
                        WHERE Corporates.CountryCode = Countries.Code
                        ORDER BY Corporates.Name
                    ;";
                    $getRows_Corporates->query($query_getRows_Corporates);
                    $rows_Corporates = $getRows_Corporates->resultset();
                    foreach ($rows_Corporates as $row_Corporates) {
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li>".$row_Corporates->Name."</li>";
                        echo "<li>".$row_Corporates->Chain."</li>";
                        echo "<li>".$row_Corporates->Type."</li>";
                        echo "<li><a href=\"corporatesEdit.php?corporatesId=$row_Corporates->Id\">";
                        echo "View Details</a></li>";
                        echo "</ul>";
                        echo "</div><!-- End of grid-item-->";
                    }
                    ?>
                </div>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
