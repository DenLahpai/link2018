<?php
require "functions.php";
//inserting data to the table ServiceType
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Code = $_REQUEST['Code'];
    $Type = trim($_REQUEST['Type']);

    //checking for duplications
    $check_ServiceType = new Database();
    $query_check_ServiceType = "SELECT * FROM ServiceType WHERE
    Code = :Code OR Type = :Type ";
    $check_ServiceType->query($query_check_ServiceType);
    $check_ServiceType->bind(':Code', $Code);
    $check_ServiceType->bind(':Type', $Type);
    $rowCount_ServiceType = $check_ServiceType->rowCount();
    if ($rowCount_ServiceType > 0) {
        $msg_error = $duplicate_entry;
    }
    else {
        //inserting data
        $insert_ServiceType = new Database();
        $query_insert_ServiceType = "INSERT INTO ServiceType (
            Code,
            Type
            ) VALUES(
            :Code,
            :Type
            )
        ;";
        $insert_ServiceType->query($query_insert_ServiceType);
        $insert_ServiceType->bind(':Code', $Code);
        $insert_ServiceType->bind(':Type', $Type);
        if($insert_ServiceType->execute()) {
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
    $title = "Service Type";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Service Type";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form serviceType" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Code">Code:</label>
                            <input type="text" name="Code" id="Code"
                            size="2" maxlength="2" required>
                        </li>
                        <li>
                            <label for="Type">Type:</label>
                            <input type="text" name="Type" id="Type" required>
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
                            <th>Type</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //getting data from the table ServiceType
                    $rows_ServiceType = getRows_ServiceType(NULL);
                    foreach ($rows_ServiceType as $row_ServiceType) {
                        echo "<tr>";
                        echo "<td>".$row_ServiceType->Code."</td>";
                        echo "<td>".$row_ServiceType->Type."</td>";
                        echo "<td><a href=\"serviceTypeEdit.php?ServiceTypeId=$row_ServiceType->Id\">Edit</a></td>";
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
