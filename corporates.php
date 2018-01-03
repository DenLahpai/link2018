<?php
require "conn.php";

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
                            <input type="text" name="Website" id="Website">
                        </li>
                    </ul>
                </form>
                <div class="grid-div">

                </div>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
