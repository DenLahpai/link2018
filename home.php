<?php
require "conn.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "New Booking";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Create New Booking";
            include "includes/nav.html";
            include "includes/header.html";
            ?>
            <main>
                <form action="#" method="post" class="form big">
                    <ul>
                        <li>
                            <input type="text" name="Name" id="Name" placeholder="Name">
                        </li>
                        <li>
                            <select name="selectAgent">
                                <option value="0">Select One</option>
                                <?php
                                $getRows_Agents = new Database();
                                $query_getRows_Agents = "SELECT * FROM Agents ORDER BY Name; ";
                                $getRows_Agents->query($query_getRows_Agents);
                                $rows_Agents = $getRows_Agents->resultset();
                                foreach ($rows_Agents as $row_Agents) {
                                    echo "<option id=\"$row_Agents->Id\">".$row_Agents->Name."</option>";                                    
                                }
                                ?>
                            </select>

                        </li>
                    </ul>
                </form>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html";?>
    </body>
</html>
