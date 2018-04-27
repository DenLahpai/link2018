<?php
require "functions.php";

//inserting data to the table Countries
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Code = $_REQUEST['Code'];
    $Country = trim($_REQUEST['Country']);
    $Region = trim($_REQUEST['Region']);

    //checking for empty fields!
    if(empty($Code) || empty($Country) || empty($Region)) {
        $msg_error = $empty_field;
    }
    else {
        //checking for duplications
        $check_Countries = new Database();
        $query_check_Countries = "SELECT * FROM Countries WHERE Code = :Code ;";
        $check_Countries->query($query_check_Countries);
        $check_Countries->bind(':Code', $Code);
        $rowCount_Countries = $check_Countries->rowCount();
        if ($rowCount_Countries > 0 ) {
            $msg_error = $duplicate_entry;
        }
        else {
            //inserting data
            $insert_Countries = new Database();
            $query_insert_Countries = "INSERT INTO Countries (
                Code,
                Country,
                Region
                ) VALUES(
                :Code,
                :Country,
                :Region
                )
            ;";
            $insert_Countries->query($query_insert_Countries);
            $insert_Countries->bind(':Code', $Code);
            $insert_Countries->bind(':Country', $Country);
            $insert_Countries->bind(':Region', $Region);
            if($insert_Countries->execute()) {
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
        $title = "Countries";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Countries";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form countries" id="form_countries" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Code">Country Code:</label>
                            <input type="text" name="Code" id="Code" size="2" maxlength="2" required>
                        </li>
                        <li>
                            <label for="Country">Country:</label>
                            <input type="text" name="Country" id="Country"
                            placeholder="Country Name">
                        </li>
                        <li>
                            <label for="Region">Region:</label>
                            <input type="text" name="Region" id="Region" placeholder="Region">
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
                            <th>Country</th>
                            <th>Region</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //getting the data from the table Countries
                    $rows_Countries = getRows_Countries(NULL);
                    foreach ($rows_Countries as $row_Countries) {
                        echo "<tr>";
                        echo "<td>".$row_Countries->Code."</td>";
                        echo "<td>".$row_Countries->Country."</td>";
                        echo "<td>".$row_Countries->Region."</td>";
                        echo "<td><a href=\"CountriesEdit.php?CountriesId=$row_Countries->Id\">Edit</a></td>";
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
