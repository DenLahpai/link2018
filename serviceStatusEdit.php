<?php
require "functions.php";
$ServiceStatusId = trim($_REQUEST['ServiceStatusId']);

//Updating data to the table ServiceStatus
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Code = trim($_REQUEST['Code']);
    $Status = trim($_REQUEST['Status']);

    $update_ServiceStatus = new Database();
    $query_update_ServiceStatus = "UPDATE ServiceStatus SET
        Code = :Code,
        Status = :Status
        WHERE Id = :ServiceStatusId
    ;";
    $update_ServiceStatus->query($query_update_ServiceStatus);
    $update_ServiceStatus->bind(':Code', $Code);
    $update_ServiceStatus->bind(':Status', $Status);
    $update_ServiceStatus->bind(':ServiceStatusId', $ServiceStatusId);
    $update_ServiceStatus->execute();
}

//getting data from the table ServiceStatus
$rows_ServiceStatus = getRows_ServiceStatus($ServiceStatusId);
foreach ($rows_ServiceStatus as $row_ServiceStatus) {
    # code...
}

?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Edit Service Status";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Service Status";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form ServiceStatus" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Code">Code:</label>
                            <input type="text" name="Code" id="Code"
                            value="<?php echo $row_ServiceStatus->Code; ?>">
                        </li>
                        <li>
                            <label for="Status">Status:</label>
                            <input type="text" name="Status" id="Status"
                            value="<?php echo $row_ServiceStatus->Status; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Update</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
