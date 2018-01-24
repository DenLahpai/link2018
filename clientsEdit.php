<?php
require "functions.php";

$ClientsId = trim($_REQUEST['ClientsId']);

//Getting one row from the table Client
$row_Clients = getRow_Clients($ClientsId);
foreach ($row_Clients as $data_Clients) {
    
}
?>
<html>
    <?php 
    $title = 'Edit Client';
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Client: ".$data_Clients->Title.
            " ".$data_Clients->FirstName." ".$data_Clients->LastName;
            include "includes/header.html";  
            include "includes/nav.html";  
            ?> 
            <section>
                <form class="form clients" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Title">Title:</label>
                            <select name="Title">
                            <?php selectTitles($data_Clients->Title); ?>
                            </select>
                        </li>
                        <li>
                            <label for="FirstName">First Name:</label>
                            <input type="text" name="FirstName" id="FirstName" 
                            value="<?php echo $data_Clients->FirstName; ?>" required>
                        </li>
                        <li>
                            <label for="LastName">Last Name:</label>
                            <input type="text" name="LastName" id="LastName" 
                            value="<?php echo $data_Clients->LastName; ?>">
                        </li>
                    </ul>
                </form>
            </section>       
        </div><!-- end of content --> 
    </body>
</html>