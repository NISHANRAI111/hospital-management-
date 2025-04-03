<?php

require_once '../database/database_connection.php';
$doctor_id = $pdo->query("SELECT doctor_id FROM doctors WHERE user_id = " . $_SESSION['user_id'])->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate - Doctor Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo"><img src="../assets/icon.webp" alt="Hospital Logo"><h2>Doctor Dashboard</h2></div>
        <form action="../Action/logout.php" method="post"><button type="submit">Logout</button></form>
    </header>
    <section class="main">
        <aside class="ver-nav-bar">
            <a href="home.php">Home</a>
            <a href="patient.php">Patients</a>
            <a href="appointments.php">Appointments</a>
            <a href="profile.php">Profile</a>
            <a href="report.php">Report</a>
            <a class="active" href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="rate">
            <h1>Your Feedback</h1>
            <div id="feedback-list"></div>
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
            url: '../Action/get_feedback.php',
            type: 'POST',
            data: { doctor_id: <?php echo $doctor_id; ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Patient</th><th>Rating</th><th>Comments</th></tr>';
                    response.feedback.forEach(function(fb) {
                        html += `<tr><td>${fb.patient_name}</td><td>${fb.rating}</td><td>${fb.comments || 'N/A'}</td></tr>`;
                    });
                    html += '</table>';
                    $('#feedback-list').html(html);
                } else {
                    $('#feedback-list').html('<p>No feedback.</p>');
                }
            }
        });
    });
    </script>
</body>
</html>