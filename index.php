<?php
session_start();

//setting up the time zone
date_default_timezone_set("Asia/Yangon");
//Uncomment the two lines below to get error reporting as a dev enviroment.
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = "Welcome";
        $msg_error = NULL;
        include "includes/head.html";
        ?>
        <style media="screen">
            main {
                text-align: center;
            }
        </style>

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
                        if(isset($_SESSION['msg_error'])) {
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
