<?php require "functions.php"; ?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Admin";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Administration";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <div class="links">
                    <ul>
                        <li>
                            <a href="countries.php">Countries</a>
                        </li>
                        <li>
                            <a href="cities.php">Cities</a>
                        </li>
                        <li>
                            <a href="corporates.php">Corporates</a>
                        </li>
                        <li>
                            <a href="corporatesContacts.php">Coroporates Contact</a>
                        </li>
                        <li>
                            <a href="suppliers.php">Suppliers</a>
                        </li>
                        <li>
                            <a href="supplierContacts.php">Suppplier Contacts</a>
                        </li>
                        <li>
                            <a href="serviceStatus.php">Service Status</a>
                        </li>
                        <li>
                            <a href="serviceType.php">Service Type</a>
                        </li>
                    </ul>
                </div>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
