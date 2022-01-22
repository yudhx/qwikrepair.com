<script type="text/javascript" src="js/sideNav.js" defer></script>
<script type="text/javascript" src="js/logout.js" defer></script>

<div class="sidenav">
    <a id="seniorHomepage" class="button" href="seniorHomepage.php">
        <img class="button-icon" src="src/home.svg">
        <div class="button-text font font-medium">Home</div>
    </a>
    <a id="seniorAppointments"class="button" href="seniorAppointments.php">
        <img class="button-icon" src="src/appointment.svg">
        <div class="button-text font font-medium">Appointments</div>
    </a>
    <a id="seniorHistory" class="button" href="seniorHistory.php">
        <img class="button-icon" src="src/history.svg">
        <div class="button-text font font-medium">History</div>
        <form><div><input type="hidden" name="request-type" value="getAppointmentHistory"></div></form>
    </a>
    <a id="seniorProfile" class="button" href="seniorProfile.php" type="submit">
        <img class="button-icon" src="src/profile.svg">
        <div class="button-text font font-medium">Profile</div>
        <form><div><input type="hidden" name="request-type" value="getProfileDetails"></div></form>
    </a>
    <a id="logoutBtn" class="logout-btn btn btn-blue">
        <img class="btn-icon" src="src/logout.svg">
        <div class="button-text font font-medium">Logout</div>
    </a>
</div>