<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "Welcome";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            //Setting the page title and including the page header
            $pageTitle = "Welcome";
            include "includes/header.html";
            ?>
            <main>
                <form action="login.php" method="post">
                    <ul>
                        <label for=""></label>
                    </ul>
                </form>
            </main>
        </div><!-- end of content -->
    </body>
</html>
