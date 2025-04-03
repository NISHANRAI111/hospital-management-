<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../authorization/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionists - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo"><img src="../assets/icon.webp" alt="Hospital Logo"><h2>Admin Dashboard</h2></div>
        <form action="../Action/logout.php" method="post"><button type="submit">Logout</button></form>
    </header>
    <section class="main">
        <aside class="ver-nav-bar">
            <a href="home.php">Home</a>
            <a href="patient.php">Patient</a>
            <a href="doctor.php">Doctors</a>
            <a class="active" href="recientlist.php">Receptionists</a>
            <a href="appointments.php">Appointments</a>
            <a href="report.php">Report</a>
            <a href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="receptionists">
            <h1>Manage Receptionists</h1>
            <div id="receptionists-list"></div>
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
            url: '../Action/get_receptionists.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Name</th><th>Age</th><th>Shift</th><th>Action</th></tr>';
                    response.receptionists.forEach(function(rec) {
                        html += `<tr><td>${rec.full_name}</td><td>${rec.age || 'N/A'}</td><td>${rec.work_shift || 'N/A'}</td><td><button class="delete-user" data-id="${rec.user_id}">Delete</button></td></tr>`;
                    });
                    html += '</table>';
                    $('#receptionists-list').html(html);
                } else {
                    $('#receptionists-list').html('<p>No receptionists.</p>');
                }
            }
        });

        $(document).on('click', '.delete-user', function() {
            let userId = $(this).data('id');
            if (confirm('Delete this receptionist?')) {
                $.ajax({
                    url: '../Action/delete_user.php',
                    type: 'POST',
                    data: { user_id: userId, role: 'Receptionist' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') location.reload();
                        else alert('Error: ' + response.message);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>