<?php
require "functions.php";
$ServiceTypeId = trim($_REQUEST['ServiceTypeId']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Code = trim($_REQUEST['Code']);
    $Type = trim($_REQUEST['Type']);

    $update_ServiceType = new Database();
    $query_update_ServiceType = "UPDATE ServiceType SET
        Code = :Code,
        Type = :Type
        WHERE Id = :ServiceTypeId
    ;";
    $update_ServiceType->query($query_update_ServiceType);
    $update_ServiceType->bind(':Code', $Code);
    $update_ServiceType->bind(':Type', $Type);
    $update_ServiceType->bind(':ServiceTypeId', $ServiceTypeId);
    $update_ServiceType->execute();
}

//getting data from the table ServiceType
$rows_ServiceType = getRows_ServiceType($ServiceTypeId);
foreach ($rows_ServiceType as $row_ServiceType) {

}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Edit Service Type";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Serivce Type";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form serviceType" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Code">Code:</label>
                            <input type="text" name="Code"
                            value="<?php echo $row_ServiceType->Code; ?>" required>
                        </li>
                        <li>
                            <label for="Type">Type:</label>
                            <input type="text" name="Type"
                            value="<?php echo $row_ServiceType->Type; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
