<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Doctor') {
    header("Location: /authorization/login.php");
    exit;
}

require_once '../database/database_connection.php';
$doctor_id = $pdo->query("SELECT doctor_id FROM doctors WHERE user_id = " . $_SESSION['user_id'])->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Doctor Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/icon.webp" alt="Hospital Logo">
            <h2>Doctor Dashboard</h2>
        </div>
        <form action="../Action/logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </header>
    <section class="main">
        <aside class="ver-nav-bar">
            <a class="active" href="home.php">Home</a>
            <a href="patient.php">Patients</a>
            <a href="appointments.php">Appointments</a>
            <a href="profile.php">Profile</a>
            <a href="report.php">Report</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="home">
            <h1>Welcome, Dr. <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Here you can manage your appointments, view patient information, and generate reports.</p>
            <h2>Upcoming Appointments</h2>
            <div id="appointments-list">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </section>
    <footer>
        <p>© 2025 MNMN | All Rights Reserved</p>
        <p>Healthroid does not offer medical advice, diagnosis or treatment.</p>
        <p>The materials provided on our website, including services, content and products, are solely intended to provide informational purposes.</p>
        <p>Created and Designed by Manoj KC and Nishan Rai</p>
    </footer>

    <script>
    $(document).ready(function() {
        // Fetch upcoming appointments
        $.ajax({
            url: '../Action/get_appointments.php',
            type: 'POST',
            data: { doctor_id: <?php echo $doctor_id; ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Date</th><th>Patient</th><th>Status</th></tr>';
                    response.appointments.forEach(function(apt) {
                        html += `<tr><td>${apt.appointment_date}</td><td>${apt.patient_name}</td><td>${apt.status}</td></tr>`;
                    });
                    html += '</table>';
                    $('#appointments-list').html(html);
                } else {
                    $('#appointments-list').html('<p>No upcoming appointments.</p>');
                }
            },
            error: function() {
                $('#appointments-list').html('<p>Error loading appointments.</p>');
            }
        });
    });
    </script>
</body>
</html>