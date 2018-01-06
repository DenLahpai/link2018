<?php
require "functions.php";
$BookingsId = $_REQUEST['BookingsId'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    $CorporatesId = $_REQUEST['CorporatesId'];
    $ArvDate = $_REQUEST['ArvDate'];
    $Pax = trim($_REQUEST['Pax']);
    $Status = $_REQUEST['Status'];
    $Remark = trim($_REQUEST['Remark']);
    $Exchange = trim($_REQUEST['Exchange']);
    $UserId = $_SESSION['UsersId'];

    if(empty($Name) || empty($Pax) || $Pax <= 0 || empty($Exchange) || $Exchange <= 0) {
        $msg_error = $empty_field;
    }
    else {
        //update
        $update_Bookings = new Database();
        $query_update_Bookings = "UPDATE Bookings SET
            Name = :Name,
            CorporatesId = :CorporatesId,
            ArvDate = :ArvDate,
            Pax = :Pax,
            Status = :Status,
            Remark = :Remark,
            Exchange = :Exchange,
            UserId = :UserId
            WHERE Id = :BookingsId
        ;";
        $update_Bookings->query($query_update_Bookings);
        $update_Bookings->bind(':Name', $Name);
        $update_Bookings->bind(':CorporatesId', $CorporatesId);
        $update_Bookings->bind(':ArvDate', $ArvDate);
        $update_Bookings->bind(':Pax', $Pax);
        $update_Bookings->bind(':Status', $Status);
        $update_Bookings->bind(':Remark', $Remark);
        $update_Bookings->bind(':Exchange', $Exchange);
        $update_Bookings->bind(':UserId', $UserId);
        $update_Bookings->bind(':BookingsId', $BookingsId);
        if($update_Bookings->execute()) {
            $msg_error = NULL;
        }
        else {
            $msg_error = $connection_problem;
        }
    }
}

//getting one data from Bookings
$row_Bookings = get_row_Bookings($BookingsId);
foreach ($row_Bookings AS $data_Bookings) {
    $Name = $data_Bookings->BookingsName;
    $CorporatesId = $data_Bookings->CorporatesId;
    $ArvDate = $data_Bookings->ArvDate;
    $Pax = $data_Bookings->Pax;
    $Status = $data_Bookings->Status;
    $Remark = $data_Bookings->Remark;
    $Exchange = $data_Bookings->Exchange;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $title = $data_Bookings->Reference;
        require "includes/head.html";
        ?>
    </head>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Booking";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form action="#" method="post" class="form big" id="formEditBooking">
                    <ul>
                        <li>
                            Name:
                            <input type="text" name="Name" id="Name" value="<?php echo $Name; ?>" required>
                        </li>
                        <li>
                            Corporate:
                            <select name="CorporatesId">
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
                                $getRows_Corporates->bind(':CorporatesId', $CorporatesId);
                                $rows_Corporates = $getRows_Corporates->resultset();
                                foreach ($rows_Corporates as $row_Corporates) {
                                    if($row_Corporates->Id == $CorporatesId) {
                                        echo "<option value=\"$row_Corporates->Id\" selected>";
                                        echo $row_Corporates->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_Corporates->Id\">";
                                        echo $row_Corporates->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Arrival Date:
                            <input type="date" name="ArvDate" id="ArvDate"
                            value="<?php echo $ArvDate; ?>" required>
                        </li>
                        <li>
                            Pax:
                            <input type="number" name="Pax" id="Pax"
                            value="<?php echo $Pax; ?>" min="1">
                        </li>
                        <li>
                            Booking Status:
                            <select name="Status">
                                <?php
                                switch ($Status) {
                                    case 'Confirmed':
                                        echo "<option value=\"Confirmed\" selected>Confirmed</option>";
                                        echo "<option value=\"Cancelled\">Cancelled</option>";
                                        echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                        break;
                                    case 'Not Confirmed':
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Not Confirmed\" selected>Not Confirmed</option>";
                                        echo "<option value=\"Cancelled\">Cancelled</option>";
                                        break;
                                    default:
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Cancelled\" selected>Cancelled</option>";
                                        echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                        break;
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Remark:
                            <input type="text" name="Remark" id="Remark"
                            value="<?php echo $Remark; ?>">
                        </li>
                        <li>
                            Exchange Rate:
                            <input type="number" name="Exchange" id="Exchange"
                            value="<?php echo $Exchange; ?>">
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
