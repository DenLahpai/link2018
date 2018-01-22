<?php
require "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = get_row_Bookings($BookingsId);
foreach ($rows_Bookings as $row_Bookings) {
    $Reference = $row_Bookings->Reference;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Getting data from the form to the variables
    $Title = $_REQUEST['Title'];
    $FirstName = trim($_REQUEST['FirstName']);
    $LastName = trim($_REQUEST['LastName']);
    $PassportNo = trim($_REQUEST['PassportNo']);
    $PassportExpiry = trim($_REQUEST['PassportExpiry']);
    $NRCNo = trim($_REQUEST['NRCNo']);
    $DOB = trim($_REQUEST['DOB']);
    $Country = trim($_REQUEST['Country']);
    $Company = trim($_REQUEST['Company']);
    $Phone = trim($_REQUEST['Phone']);
    $Email = trim($_REQUEST['Email']);
    $Website = trim($_REQUEST['Website']);

    if($Title == NULL || empty($Title)) {
        $msg_error = $empty_field;
    }
    else {
        $check_Clients = new Database();
        $query_check_Clients = "SELECT * FROM Clients
            WHERE FirstName = :FirstName
            AND LastName = :LastName
            AND NRCNo = :NRCNo
        ;";
        $check_Clients->query($query_check_Clients);
        $check_Clients->bind(':FirstName', $FirstName);
        $check_Clients->bind(':LastName', $LastName);
        $check_Clients->bind(':NRCNo', $NRCNo);
        $rowCount = $check_Clients->rowCount();
        if($rowCount == 0) {
            //inserting data to the table Clinets
            $insert_Clients = new Database();
            $query_insert_Clients = "INSERT INTO Clients (
                Title,
                FirstName,
                LastName,
                PassportNo,
                PassportExpiry,
                NRCNo,
                DOB,
                Country,
                FrequentFlyer,
                Company,
                Phone,
                Email,
                Website
                ) VALUES(
                :Title,
                :FirstName,
                :LastName,
                :PassportNo,
                :PassportExpiry,
                :NRCNo,
                :DOB,
                :Country,
                :FrequentFlyer,
                :Company,
                :Phone,
                :Email,
                :Website
                )
            ;";
            $insert_Clients->query($query_insert_Clients);
            $insert_Clients->bind(':Title', $Title);
            $insert_Clients->bind(':FirstName', $FirstName);
            $insert_Clients->bind(':LastName', $LastName);
            $insert_Clients->bind(':PassportNo', $PassportNo);
            $insert_Clients->bind(':PassportExpiry', $PassportExpiry);
            $insert_Clients->bind(':NRCNo', $NRCNo);
            $insert_Clients->bind(':DOB', $DOB);
            $insert_Clients->bind(':Country', $Country);
            $insert_Clients->bind(':FrequentFlyer', $FrequentFlyer);
            $insert_Clients->bind(':Company', $Company);
            $insert_Clients->bind(':Phone', $Phone);
            $insert_Clients->bind(':Email', $Email);
            $insert_Clients->bind(':Website', $Website);
            if($insert_Clients->execute()) {
                header("location:clients_add.php?BookingsId=$BookingsId");
            }
            else {
                $msg_error = $connection_problem;
            }
        }
        else {
            $msg_error = $duplicate_entry;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <?php
    $title = "Add Client";
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Add Client";
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/menu_bookings.html";
            ?>
            <section>
                <form class="form clients" action="#" method="post">
                    <h3 style="text-align: center;">New Client</h3>
                    <ul>
                        <li>
                            <label for="Title">Title:</label>
                            <select name="Title">
                            <?php selectTitles($Title); ?>
                            </select>
                        </li>
                        <li>
                            <label for="FirstName">First Name:</label>
                            <input type="text" name="FirstName" id="FirstName"
                            placeholder="First Name" required>
                        </li>
                        <li>
                            <label for="LastName">Last Name:</label>
                            <input type="text" name="LastName" id="LastName" placeholder="Last Name">
                        </li>
                        <li>
                            <label for="PassportNo">Passport No:</label>
                            <input type="text" name="PassportNo" id="PassportNo" placeholder="Passport No">
                        </li>
                        <li>
                            <label for="PassportExpiry">Expiry Date:</label>
                            <input type="date" name="PassportExpiry" id="PassportExpiry">
                        </li>
                        <li>
                            <label for="NRCNo">NRC:</label>
                            <input type="text" name="NRCNo" id="NRCNo" placeholder="NRCNo">
                        </li>
                        <li>
                            <label for="DOB">DBO:</label>
                            <input type="date" name="DOB" id="DOB">
                        </li>
                        <li>
                            <label for="Country">Country:</label>
                            <input type="text" name="Country" id="Country" placeholder="Country">
                        </li>
                        <li>
                            <label for="Company">Company:</label>
                            <input type="text" name="Company" id="Company" placeholder="Company">
                        </li>
                        <li>
                            <label for="Phone">Phone:</label>
                            <input type="text" name="Phone" id="Phone" placeholder="Phone">
                        </li>
                        <li>
                            <label for="Email">Email:</label>
                            <input type="text" name="Email" id="Email" placeholder="Email">
                        </li>
                        <li>
                            <label for="Website">Website:</label>
                            <input type="text" name="Website" id="Website" placeholder="Website">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubit">Submit</button>
                        </li>
                        <li>
                            <a href="<?php echo "booking_addExistingClient.php?BookingsId=$BookingsId"; ?>" target="_blank">Add from Existing Clients</a>
                        </li>
                    </ul>
                </form>
            </section>
            <main>
                <h3>Clients for <?php echo $Reference; ?></h3>
                <?php
                //getting Clients from the booking
                $rows_Clients = getRows_Clients($BookingsId);
                foreach ($rows_Clients as $row_Clients) {
                    echo "<ul>";
                    echo "<li>".$row_Clients->Title;
                    echo " ".$row_Clients->FirstName;
                    echo " ".$row_Clients->LastName."</li>";
                    echo "<li>".$row_Clients->NRCNo."</li>";
                    echo "<li><a href=\"clientsEdit.php?ClientsId=$row_Clients->Id\" target=\"_blank\">Edit</a></li>";
                }
                ?>
            </main>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
