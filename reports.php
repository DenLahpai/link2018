<?php
require 'functions.php';
?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Reports";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Reports";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <div class="links">
                    <ul>
                        <li>
                            <a href="report_bookings.php">Bookings</a>
                        </li>
                        <li>
                            <a href="report_invoices.php">Invoices</a>
                        </li>
                        <li>
                            <a href="report_services.php">Services</a>
                        </li>
                    </ul>
                </div>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
