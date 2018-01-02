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
                <form action="login.php" method="post" class="form login">
                    <ul>
                        <li class="error">
                        <?php
                        if($_SESSION['msg_error'] != NULL) {
                            echo $_SESSION['msg_error'];
                        }
                        ?>
                        </li>
                        <li>
                            <label for="username">Username:</label>
                            <input type="text" name="Username" id="Username" placeholder="Username">
                        </li>
                        <li>
                            <label for="password">Password:</label>
                            <input type="password" name="Password" id="Password" placeholder="Password">
                        </li>

                        <li>
                            <button type="submit" name="buttonSubmit" id="buttonSubmit" class="button_login">Login</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div><!-- end of content -->
        <?php
        include "includes/footer.html";
        ?>
    </body>
</html>
