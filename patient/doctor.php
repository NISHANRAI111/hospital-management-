<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: /authorization/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - Patient Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo"><img src="../assets/icon.webp" alt="Hospital Logo"><h2>Patient Dashboard</h2></div>
        <form action="../Action/logout.php" method="post"><button type="submit">Logout</button></form>
    </header>
    <section class="main">
        <aside class="ver-nav-bar">
            <a href="home.php">Home</a>
            <a class="active" href="doctor.php">Doctors</a>
            <a href="appointments.php">Appointments</a>
            <a href="billing.php">Billing and Payment</a>
            <a href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="doctor">
            <h1>Available Doctors</h1>
            <div id="doctors-list"></div>
        </div>
    </section>
    <footer>
        <p>© 2025 MNMN | All Rights Reserved</p>
        <p>Healthroid does not offer medical advice, diagnosis or treatment.</p>
        <p>The materials provided on our website are for informational purposes only.</p>
        <p>Created and Designed by Manoj KC and Nishan Rai</p>
    </footer>
    <script>
    $(document).ready(function() {
        $.ajax({
            url: '../Action/get_doctors.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Name</th><th>Specialization</th><th>Experience</th></tr>';
                    response.doctors.forEach(function(doc) {
                        html += `<tr><td>${doc.full_name}</td><td>${doc.specialization || 'N/A'}</td><td>${doc.years_of_experience || 'N/A'} years</td></tr>`;
                    });
                    html += '</table>';
                    $('#doctors-list').html(html);
                } else {
                    $('#doctors-list').html('<p>No doctors available.</p>');
                }
            },
            error: function() {
                $('#doctors-list').html('<p>Error loading doctors.</p>');
            }
        });
    });
    </script>
</body>
</html>