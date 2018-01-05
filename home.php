<?php
require "functions.php";

//inserting data to the table Bookings
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    $CorporatesId = $_REQUEST['CorporatesId'];
    $ArvDate = $_REQUEST['ArvDate'];
    $Pax = $_REQUEST['Pax'];
    $Status = $_REQUEST['Status'];
    $Remark = trim($_REQUEST['Remark']);
    $Exchange = trim($_REQUEST['Exchange']);
    $UserId = $_SESSION['UsersId'];

    if(empty($CorporatesId) || $Pax <= 0 || empty($Pax) || empty($Exchange)) {
        $msg_error = $empty_field;
    }
    else {
        //Checking for duplications
        $check_Bookings = new Database();
        $query_check_Bookings = "SELECT * FROM Bookings
            WHERE Name = :Name
            AND ArvDate = :ArvDate
            AND Pax = :Pax
        ;";
        $check_Bookings->query($query_check_Bookings);
        $check_Bookings->bind(':Name', $Name);
        $check_Bookings->bind(':ArvDate', $ArvDate);
        $check_Bookings->bind(':Pax', $Pax);
        $rowCount_Check_Bookings = $check_Bookings->rowCount();
        if ($rowCount_Check_Bookings > 0) {
            $msg_error = $duplicate_entry;
        }
        else {
            //Generaing Reference Number
            $get_Reference = new Database();
            $query_get_Reference = "SELECT * FROM Bookings;";
            $get_Reference->query($query_get_Reference);
            $rowCount_get_Reference = $get_Reference->rowCount();
            $r = $rowCount_get_Reference + 1;
            $Reference = $get_Reference->generate_Reference($r);

            //insertng data
            $insert_Bookings = new Database();
            $query_insert_Bookings = "INSERT INTO Bookings (
                Reference,
                Name,
                CorporatesId,
                ArvDate,
                Pax,
                Status,
                Remark,
                Exchange,
                UserId
                ) VALUES (
                :Reference,
                :Name,
                :CorporatesId,
                :ArvDate,
                :Pax,
                :Status,
                :Remark,
                :Exchange,
                :UserId
                )
            ;";
            $insert_Bookings->query($query_insert_Bookings);
            $insert_Bookings->bind(':Reference', $Reference);
            $insert_Bookings->bind(':Name', $Name);
            $insert_Bookings->bind(':CorporatesId', $CorporatesId);
            $insert_Bookings->bind(':ArvDate', $ArvDate);
            $insert_Bookings->bind(':Pax', $Pax);
            $insert_Bookings->bind(':Status', $Status);
            $insert_Bookings->bind(':Remark', $Remark);
            $insert_Bookings->bind(':Exchange', $Exchange);
            $insert_Bookings->bind(':UserId', $UserId);
            if($insert_Bookings->execute()) {
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
    <head>
        <?php
        $title = "New Booking";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Create New Booking";
            include "includes/nav.html";
            include "includes/header.html";
            ?>
            <section>
                <form action="#" method="post" class="form big">
                    <ul>
                        <li>
                            Name:
                            <input type="text" name="Name" id="Name" placeholder="Name" required>
                        </li>
                        <li>
                            Corporate:
                            <select name="CorporatesId">
                                <option value="">Select Corporates</option>
                                <?php
                                $getRows_Corporates = new Database();
                                $query_getRows_Corporates = "SELECT
                                    Corporates.Id,
                                    Corporates.Name,
                                    Corporates.Chain,
                                    Corporates.Type,
                                    Countries.Country,
                                    Corporates.Email,
                                    Corporates.Website
                                    FROM Corporates, Countries
                                    WHERE Corporates.CountryCode = Countries.Code
                                    ORDER BY Corporates.Name
                                ;";
                                $getRows_Corporates->query($query_getRows_Corporates);
                                $rows_Corporates = $getRows_Corporates->resultset();
                                foreach ($rows_Corporates as $row_Corporates) {
                                    echo "<option value=\"$row_Corporates->Id\">";
                                    echo $row_Corporates->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Arrival Date:
                            <input type="date" name="ArvDate" id="ArvDate" required>
                        </li>
                        <li>
                            Pax:
                            <input type="number" name="Pax" id="Pax" placeholder="Pax" min="1">
                        </li>
                        <li>
                            Booking Status:
                            <select name="Status">
                                <option value="Confirmed">Confirmed</option>
                                <option value="Not Confirmed">Not Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </li>
                        <li>
                            Remark:
                            <input type="text" name="Remark" id="Remark" placeholder="Remark">
                        </li>
                        <li>
                            Exchange Rate:
                            <input type="number" name="Exchange" id="Exchange"
                            placeholder="Exchange Rate" required>
                        </li>
                        <li>
                            <button type="submit" name="buttonSubmit">Submit</button>
                        </li>                        
                    </ul>
                </form>
            </section>
            <main>
                <h3>Bookings in one Week</h3>
                <div class="grid-div"><!-- grid-div -->
                    <?php
                    $today = date("Y-m-d");
                    $sevendays = date("Y-m-d", strtotime ('+ 7 days'));
                    //getting data from the table Bookings
                    $getRows_Bookings = new Database();
                    $query_getRows_Bookings = "SELECT
                        Bookings.Id AS BookingsId,
                        Bookings.Reference,
                        Bookings.Name AS BookingName,
                        Corporates.Name AS CorporateName,
                        Bookings.ArvDate,
                        Bookings.Pax,
                        Bookings.Status,
                        Users.Username
                        FROM Bookings, Corporates, Users
                        WHERE Bookings.CorporatesId = Corporates.Id
                        AND Bookings.UserId = Users.Id
                        AND ArvDate >= :today
                        AND ArvDate <= :sevendays
                    ;";
                    $getRows_Bookings->query($query_getRows_Bookings);
                    $getRows_Bookings->bind(':today', $today);
                    $getRows_Bookings->bind(':sevendays', $sevendays);
                    $rows_Bookings = $getRows_Bookings->resultset();

                    foreach ($rows_Bookings as $row_Bookings) {
                        echo "<div class=\"grid-item\"><!-- grid-item -->";
                        echo "<ul>";
                        echo "<li><a href=\"booking_details.php?BookingsId=$row_Bookings->BookingsId\">".$row_Bookings->Reference."</a></li>";
                        echo "<li>".$row_Bookings->BookingName;
                        echo " X ".$row_Bookings->Pax." Pers</li>";
                        echo "<li>".$row_Bookings->CorporateName."</li>";
                        echo "<li style=\"font-weight: bold;\">";
                        echo date("d-M-Y", strtotime($row_Bookings->ArvDate))."</li>";
                        echo "<li style=\"font-style: italic;\">By ";
                        echo $row_Bookings->Username."</li>";
                        echo "<li><a href=\"bookingsEdit.php?BookingsId=$row_Bookings->BookingsId\">Edit</a></li>";
                        echo "</div><!-- end of grid-item --!>";
                    }
                    ?>
                </div><!-- end of grid-div -->
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html";?>
    </body>
</html>
