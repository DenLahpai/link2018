<?php
require "functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    $Address = trim($_REQUEST['Address']);
    $City = trim($_REQUEST['City']);
    $Email = trim($_REQUEST['Email']);
    $Phone = trim($_REQUEST['Phone']);
    $Fax = trim($_REQUEST['Fax']);
    $Website = trim($_REQUEST['Website']);

    $insert_Suppliers = new Database();
    $query_insert_Suppliers = "INSERT INTO Suppliers (
        Name,
        Address,
        City,
        Email,
        Phone,
        Fax,
        Website
        ) VALUES (
        :Name,
        :Address,
        :City,
        :Email,
        :Phone,
        :Fax,
        :Website
        )
    ;";
    $insert_Suppliers->query($query_insert_Suppliers);
    $insert_Suppliers->bind(':Name', $Name);
    $insert_Suppliers->bind(':Address', $Address);
    $insert_Suppliers->bind(':City', $City);
    $insert_Suppliers->bind(':Email', $Email);
    $insert_Suppliers->bind(':Phone', $Phone);
    $insert_Suppliers->bind(':Fax', $Fax);
    $insert_Suppliers->bind(':Website', $Website);
    $insert_Suppliers->execute();
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Suppliers";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Suppliers";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form suppliers" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Name">Name:</label>
                            <input type="text" name="Name" id="Name" placeholder="Supplier Name">
                        </li>
                        <li>
                            <label for="Address">Address:</label>
                            <input type="text" name="Address" id="Address" placeholder="Supplier Address">
                        </li>
                        <li>
                            <label for="City">City:</label>
                            <input type="text" name="City" id="City" placeholder="City">
                        </li>
                        <li>
                            <label for="Email">Email:</label>
                            <input type="text" name="Email" id="Email" placeholder="General Email">
                        </li>
                        <li>
                            <label for="Phone">Phone:</label>
                            <input type="text" name="Phone" id="Phone" placeholder="Phone">
                        </li>
                        <li>
                            <label for="Fax">Fax:</label>
                            <input type="text" name="Fax" id="Fax" placeholder="Fax">
                        </li>
                        <li>
                            <label for="Website">Website:</label>
                            <input type="text" name="Website" id="Website" placeholder="Website">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>City</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // getting data from the table Suppliers
                    $rows_Suppliers = getRows_Suppliers(NULL);
                    foreach ($rows_Suppliers as $row_Suppliers) {
                        echo "<tr>";
                        echo "<td>".$row_Suppliers->Name."</td>";
                        echo "<td>".$row_Suppliers->City."</td>";
                        echo "<td><a href=\"SuppliersEdit.php?SuppliersId=$row_Suppliers->Id\">";
                        echo "Edit</a></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
