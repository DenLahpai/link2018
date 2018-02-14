<?php
require "functions.php";

//getting data from the table SupplierContacts
$SupplierContactsId = trim($_REQUEST['SupplierContactsId']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Title = $_REQUEST['Title'];
    $FirstName = trim($_REQUEST['FirstName']);
    $LastName = trim($_REQUEST['LastName']);
    $SupplierId = $_REQUEST['SupplierId'];
    $Email = trim($_REQUEST['Email']);
    $Phone = trim($_REQUEST['Phone']);

    $update_SupplierContacts = new Database();
    $query_update_SupplierContacts = "UPDATE SupplierContacts SET
        Title = :Title,
        FirstName = :FirstName,
        LastName = :LastName,
        SupplierId = :SupplierId,
        Email = :Email,
        Phone = :Phone
        WHERE Id = :SupplierContactsId
    ;";
    $update_SupplierContacts->query($query_update_SupplierContacts);
    $update_SupplierContacts->bind(':Title', $Title);
    $update_SupplierContacts->bind(':FirstName', $FirstName);
    $update_SupplierContacts->bind(':LastName', $LastName);
    $update_SupplierContacts->bind(':SupplierId', $SupplierId);
    $update_SupplierContacts->bind(':Email', $Email);
    $update_SupplierContacts->bind(':Phone', $Phone);
    $update_SupplierContacts->bind(':SupplierContactsId', $SupplierContactsId);
    $update_SupplierContacts->execute();
}

$rows_SupplierContacts = getRows_SupplierContacts($SupplierContactsId);
foreach ($rows_SupplierContacts as $row_SupplierContacts) {
    # code...
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Supplier Contacts Edit";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Supplier Contact";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form supplierContacts" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Title">Title:</label>
                            <select name="Title">
                            <?php selectTitles($row_SupplierContacts->Title); ?>
                            </select>
                        </li>
                        <li>
                            <label for="FirstName">First Name:</label>
                            <input type="text" name="FirstName" id="FirstName"
                            value="<?php echo $row_SupplierContacts->FirstName; ?>">
                        </li>
                        <li>
                            <label for="LasttName">Last Name:</label>
                            <input type="text" name="LastName" id="LastName"
                            value="<?php echo $row_SupplierContacts->LastName; ?>">
                        </li>
                        <li>
                            <label for="SupplierId">Supplier:</label>
                            <select name="SupplierId">
                                <?php
                                $rows_Suppliers = getRows_Suppliers(NULL);
                                foreach ($rows_Suppliers as $row_Suppliers) {
                                    if($row_Suppliers->SupplierId == $row_SupplierContacts->SupplierId) {
                                        echo "<option value=\"$row_Suppliers->Id\" selected>".$row_Suppliers->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_Suppliers->Id\">".$row_Suppliers->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="Email">Email:</label>
                            <input type="text" name="Email" id="Email" value="<?php echo $row_SupplierContacts->Email; ?>">
                        </li>
                        <li>
                            <label for="Phone">Phone:</label>
                            <input type="text" name="Phone" id="Phone" value="<?php echo $row_SupplierContacts->Phone; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Update</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
    </body>
    <?php
    include "includes/footer.html";
    ?>
</html>
