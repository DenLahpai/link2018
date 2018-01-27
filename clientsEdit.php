<?php
require "functions.php";

$ClientsId = trim($_REQUEST['ClientsId']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Title = $_REQUEST['Title'];;
    $FirstName = trim($_REQUEST['FirstName']);
    $LastName = trim($_REQUEST['LastName']);
    $PassportNo = trim($_REQUEST['PassportNo']);
    $PassportExpiry = $_REQUEST['PassportExpiry'];
    $NRCNo = trim($_REQUEST['NRCNo']);
    $DOB = $_REQUEST['DOB'];
    $Country = trim($_REQUEST['Country']);
    $FrequentFlyer = trim($_REQUEST['FrequentFlyer']);
    $Phone = trim($_REQUEST['Phone']);
    $Email = trim($_REQUEST['Email']);
    $Website = trim($_REQUEST['Website']);

    $update_Clients = new Database();
    $query_update_Clients = "UPDATE Clients SET
        Title = :Title,
        FirstName = :FirstName,
        LastName = :LastName,
        PassportNo = :PassportNo,
        PassportExpiry = :PassportExpiry,
        NRCNo = :NRCNo,
        DOB = :DOB,
        Country = :Country,
        FrequentFlyer = :FrequentFlyer,
        Phone = :Phone,
        Email = :Email,
        Website = :Website
        WHERE Id = :ClientsId
    ;";
    $update_Clients->query($query_update_Clients);
    $update_Clients->bind(':Title', $Title);
    $update_Clients->bind(':FirstName', $FirstName);
    $update_Clients->bind(':LastName', $LastName);
    $update_Clients->bind(':PassportNo', $PassportNo);
    $update_Clients->bind(':PassportExpiry', $PassportExpiry);
    $update_Clients->bind(':NRCNo', $NRCNo);
    $update_Clients->bind(':DOB', $DOB);
    $update_Clients->bind(':Country', $Country);
    $update_Clients->bind(':FrequentFlyer', $FrequentFlyer);
    $update_Clients->bind(':Phone', $Phone);
    $update_Clients->bind(':Email', $Email);
    $update_Clients->bind(':Website', $Website);
    $update_Clients->bind(':ClientsId', $ClientsId);
    $update_Clients->execute();
}

//Getting one row from the table Client
$row_Clients = getRow_Clients($ClientsId);
foreach ($row_Clients as $data_Clients) {

}
?>
<html>
    <?php
    $title = 'Edit Client';
    include "includes/head.html";
    ?>
    <body>
        <div class="content"><!-- content -->
            <?php
            $pageTitle = "Edit Client: ".$data_Clients->Title.
            " ".$data_Clients->FirstName." ".$data_Clients->LastName;
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <section>
                <form class="form clients" action="#" method="post">
                    <ul>
                        <li>
                            <label for="Title">Title:</label>
                            <select name="Title">
                            <?php selectTitles($data_Clients->Title); ?>
                            </select>
                        </li>
                        <li>
                            <label for="FirstName">First Name:</label>
                            <input type="text" name="FirstName" id="FirstName"
                            value="<?php echo $data_Clients->FirstName; ?>" required>
                        </li>
                        <li>
                            <label for="LastName">Last Name:</label>
                            <input type="text" name="LastName" id="LastName"
                            value="<?php echo $data_Clients->LastName; ?>">
                        </li>
                        <li>
                            <label for="PassportNo">Passport No:</label>
                            <input type="text" name="PassportNo" id="PassportNo"
                            value="<?php echo $data_Clients->PassportNo; ?>">
                        </li>
                        <li>
                            <label for="PassportExpiry">Expiry Date:</label>
                            <input type="date" name="PassportExpiry" id="PassportExpiry"
                            value="<?php echo $data_Clients->PassportExpiry; ?>">
                        </li>
                        <li>
                            <label for="NRCNo">NRC:</label>
                            <input type="text" name="NRCNo" id="NRCNo"
                            value="<?php echo $data_Clients->NRCNo; ?>">
                        </li>
                        <li>
                            <label for="DOB">DBO:</label>
                            <input type="date" name="DOB" id="DOB"
                            value="<?php echo $data_Clients->PassportNo; ?>">
                        </li>
                        <li>
                            <label for="Country">Country:</label>
                            <input type="text" name="Country" id="Country"
                            value="<?php echo $data_Clients->Country; ?>">
                        </li>
                        <li>
                            <label for="FrequentFlyer">Frequent Flyer:</label>
                            <input type="text" name="FrequentFlyer" id="FrequentFlyer"
                            value="<?php echo $data_Clients->FrequentFlyer; ?>">
                        </li>
                        <li>
                            <label for="Company">Company:</label>
                            <input type="text" name="Company" id="Company"
                            value="<?php echo $data_Clients->Company; ?>">
                        </li>
                        <li>
                            <label for="Phone">Phone:</label>
                            <input type="text" name="Phone" id="Phone"
                            value="<?php echo $data_Clients->Phone; ?>">
                        </li>
                        <li>
                            <label for="Email">Email:</label>
                            <input type="text" name="Email" id="Email"
                            value="<?php echo $data_Clients->Email; ?>">
                        </li>
                        <li>
                            <label for="Website">Website:</label>
                            <input type="text" name="Website" id="Website"
                            value="<?php echo $data_Clients->Website; ?>">
                        </li>
                        <li>
                            <button type="submit" name="buttonSubit">Submit</button>
                        </li>
                    </ul>
                </form>
            </section>
        </div><!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
