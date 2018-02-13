<?php
require "functions.php";

//inserting data to the table ServiceStatus
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Code = trim($_REQUEST['Code']);
    $Status = trim($_REQUEST['Status']);

    //checking for duplications
    $check_ServiceStatus = new Database();
    $query_check_ServiceStatus = "SELECT * FROM ServiceStatus
        WHERE Code = :Code
        OR Status = :Status ";
    $check_ServiceStatus->query($query_check_ServiceStatus);
    $check_ServiceStatus->bind(':Code', $Code);
    $check_ServiceStatus->bind(':Status', $Status);
    $rowCount_ServiceStatus = $check_ServiceStatus->rowCount();
    if ($rowCount_ServiceStatus > 0) {
        $msg_error = $duplicate_entry;
    }
    else {
        //inserting data
        $insert_ServiceStatus = new Database();
        $query_insert_ServiceStatus = "INSERT INTO ServiceStatus (
            Code,
            Status
            ) VALUES(
            :Code,
            :Status
            )
        ;";
        $insert_ServiceStatus->query($query_insert_ServiceStatus);
        $insert_ServiceStatus->bind(':Code', $Code);
        $insert_ServiceStatus->bind(':Status', $Status);
        if($insert_ServiceStatus->execute()) {
            $msg_error = NULL;
        }
        else {
            $msg_error = $connection_problem;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Service Status";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Service Status";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form serviceStatus" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Code">Code:</label>
                            <input type="text" name="Code" id="Code" size="2" required>
                        </li>
                        <li>
                            <label for="Status">Status:</label>
                            <input type="text" name="Status" id="Status" required>
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
                            <th>Code</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //getting data from the table ServiceStatus
                    $rows_ServiceStatus = getRows_ServiceStatus(NULL);
                    foreach ($rows_ServiceStatus as $row_ServiceStatus) {
                        echo "<tr>";
                        echo "<td>".$row_ServiceStatus->Code."</td>";
                        echo "<td>".$row_ServiceStatus->Status."</td>";
                        echo "<td><a href=\"serviceStatusEdit.php?ServiceStatusId=$row_ServiceStatus->Id\">Edit</a></td>";
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
