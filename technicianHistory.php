<?php session_start(); 
    if (isset($_SESSION['email']) && $_SESSION['role'] !== 'technician')
        header("Location: index.php");
    if (!isset($_SESSION['email']))
        header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>History</title>
    <?php include "template/header.php" ?>
    <link type="text/css" rel="stylesheet" href="css/navbar.css">
    <link type="text/css" rel="stylesheet" href="css/navbarUser.css">
    <link type="text/css" rel="stylesheet" href="css/sideNav.css">
    <link type="text/css" rel="stylesheet" href="css/technicianHistory.css">
    <script src="js/technicianHistory.js" defer></script>
</head>
<body>
    <?php include "template/navbarUser.php" ?>
    <div>
        <?php include "template/technicianSideNav.php" ?>
        <div class="content-wrapper">
        <div class="font font-large title">Appointment History</div>
            <div class="table-wrapper">
                <table class="table" id="appointmentHistoryTable">
                    <tr class="tableHeaders">
                        <th class="date-h">Date</th>
                        <th class="time-h">Time</th>
                        <th class="service-name-h">Service Name</th>
                        <th class="tech-name-h">Senior</th>
                        <th class="review-h">Review</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>