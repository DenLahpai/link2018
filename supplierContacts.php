<?php
require "functions.php";

//inserting data to the table SupplierContacts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Title = $_REQUEST['Title'];
    $FirstName = trim($_REQUEST['FirstName']);
    $LastName = trim($_REQUEST['LastName']);
    $SupplierId = $_REQUEST['SupplierId'];
    $Email = trim($_REQUEST['Email']);
    $Phone = trim($_REQUEST['Phone']);
    if (empty($SupplierId) || $SupplierId == NULL || $SupplierId == "") {
        $msg_error = $empty_field;
    }
    else {
        //checking for duplications
        $check_SupplierContacts = new Database();
        $query_check_SupplierContacts = "SELECT * FROM SupplierContacts
            WHERE FirstName = :FirstName
            AND SupplierId = :SupplierId
        ;";
        $check_SupplierContacts->query($query_check_SupplierContacts);
        $check_SupplierContacts->bind(':FirstName', $FirstName);
        $check_SupplierContacts->bind(':SupplierId', $SupplierId);
        $rowCount_SupplierContacts = $check_SupplierContacts->rowCount();
        if ($rowCount_SupplierContacts > 0) {
            $msg_error = $duplicate_entry;
        }
        else {
            $insert_SupplierContacts = new Database();
            $query_insert_SupplierContacts = "INSERT INTO SupplierContacts (
                Title,
                FirstName,
                LastName,
                SupplierId,
                Email,
                Phone
                ) VALUES(
                :Title,
                :FirstName,
                :LastName,
                :SupplierId,
                :Email,
                :Phone
                )
            ;";
            $insert_SupplierContacts->query($query_insert_SupplierContacts);
            $insert_SupplierContacts->bind(':Title', $Title);
            $insert_SupplierContacts->bind(':FirstName', $FirstName);
            $insert_SupplierContacts->bind(':LastName', $LastName);
            $insert_SupplierContacts->bind(':SupplierId', $SupplierId);
            $insert_SupplierContacts->bind(':Email', $Email);
            $insert_SupplierContacts->bind(':Phone', $Phone);
            if ($insert_SupplierContacts->execute()) {
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
    <?php
    $title = "Supplier Contacts";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Supplier Contacts";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form supplierscontacts" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Title">Title:</label>
                            <select name="Title">
                            <?php selectTitles($Title); ?>
                            </select>
                        </li>
                        <li>
                            <label for="FirstName">First Name:</label>
                            <input type="text" name="FirstName" id="FirstName" placeholder="First Name" required>
                        </li>
                        <li>
                            <label for="LastName">Last Name:</label>
                            <input type="text" name="LastName" id="LastName" placeholder="Last Name">
                        </li>
                        <li>
                            <label for="SupplierId">Supplier:</label>
                            <select name="SupplierId" id="SupplierId">
                                <option value="">Select</option>
                                <?php
                                $rows_Suppliers = getRows_Suppliers(NULL);
                                foreach ($rows_Suppliers as $row_Suppliers) {
                                    echo "<option value=\"$row_Suppliers->Id\">$row_Suppliers->Name</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="Email">Email:</label>
                            <input type="text" name="Email" id="Email" placeholder="Personal Email">
                        </li>
                        <li>
                            <label for="Phone">Phone:</label>
                            <input type="text" name="Phone" id="Phone" placeholder="Phone">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    $rows_SupplierContacts = getRows_SupplierContacts(NULL);
                    foreach($rows_SupplierContacts as $row_SupplierContacts) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<ul>";
                        echo "<li>".$row_SupplierContacts->Title." ";
                        echo $row_SupplierContacts->FirstName." ";
                        echo $row_SupplierContacts->LastName."</li>";
                        echo "<li>".$row_SupplierContacts->SupplierName."</li>";
                        echo "<li>".$row_SupplierContacts->Email."</li>";
                        echo "<li>".$row_SupplierContacts->Phone."</li>";
                        echo "<li><a href=\"supplierContactsEdit.php?SupplierContactsId=$row_SupplierContacts->Id\">";
                        echo "Edit</a></li>";
                        echo "<ul></div><!-- end of grid-item-->";
                    }
                    ?>
                </div><!-- end of grid-div -->
            </main>
        </div><!-- end of content -->
    </body>
    <?php include "includes/footer.html"; ?>
</html>
