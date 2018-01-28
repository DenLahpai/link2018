<?php
require "functions.php";
$SuppliersId = trim($_REQUEST['SuppliersId']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Passing data to the variables
    $Name = trim($_REQUEST['Name']);
    $Address = trim($_REQUEST['Address']);
    $City = trim($_REQUEST['City']);
    $Email = trim($_REQUEST['Email']);
    $Phone = trim($_REQUEST['Phone']);
    $Fax = trim($_REQUEST['Fax']);
    $Website = trim($_REQUEST['Website']);

    //updating the data in the table Suppliers
    $update_Suppliers = new Database();
    $query_update_Suppliers = "UPDATE Suppliers SET
    Name = :Name,
    Address = :Address,
    City = :City,
    Email = :Email,
    Phone = :Phone,
    Fax = :Fax,
    Website = :Website
    WHERE Id = :SuppliersId
    ;";
    $update_Suppliers->query($query_update_Suppliers);
    $update_Suppliers->bind(':Name', $Name);
    $update_Suppliers->bind(':Address', $Address);
    $update_Suppliers->bind(':City', $City);
    $update_Suppliers->bind(':Email', $Email);
    $update_Suppliers->bind(':Phone', $Phone);
    $update_Suppliers->bind(':Fax', $Fax);
    $update_Suppliers->bind(':Website', $Website);
    $update_Suppliers->bind(':SuppliersId', $SuppliersId);
    $update_Suppliers->execute();
}

$rows_Suppliers = getRows_Suppliers($SuppliersId);
foreach ($rows_Suppliers as $row_Suppliers) {

}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = 'Edit Supplier';
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Supplier";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form suppliers" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Name">Name:</label>
                            <input type="text" name="Name" id="Name"
                            value="<?php echo $row_Suppliers->Name; ?>" required>
                        </li>
                        <li>
                            <label for="Address">Address:</label>
                            <input type="text" name="Address" id="Address"
                            value="<?php echo $row_Suppliers->Address; ?>">
                        </li>
                        <li>
                            <label for="City">City:</label>
                            <input type="text" name="City" id="City"
                            value="<?php echo $row_Suppliers->City; ?>">
                        </li>
                        <li>
                            <label for="Email">Email:</label>
                            <input type="text" name="Email" id="Email"
                            value="<?php echo $row_Suppliers->Email; ?>">
                        </li>
                        <li>
                            <label for="Phone">Phone:</label>
                            <input type="text" name="Phone" id="Phone"
                            value="<?php echo $row_Suppliers->Phone; ?>">
                        </li>
                        <li>
                            <label for="Fax">Fax:</label>
                            <input type="text" name="Fax" id="Fax"
                            value="<?php echo $row_Suppliers->Fax; ?>">
                        </li>
                        <li>
                            <label for="Website">Website:</label>
                            <input type="text" name="Website" id="Website"
                            value="<?php echo $row_Suppliers->Website; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Update</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
        <?php
        include "includes/footer.html";
        ?>
    </body>
</html>
