<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: /authorization/login.php");
    exit;
}
require_once '../Action/db_connect.php';
$patient_id = $pdo->query("SELECT patient_id FROM patients WHERE user_id = " . $_SESSION['user_id'])->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Patient Dashboard</title>
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
            <a href="doctor.php">Doctors</a>
            <a class="active" href="appointments.php">Appointments</a>
            <a href="billing.php">Billing and Payment</a>
            <a href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="appointments">
            <h1>Your Appointments</h1>
            <button id="new-appointment">Request New Appointment</button>
            <div id="appointments-list"></div>
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
            url: '../Action/get_appointments.php',
            type: 'POST',
            data: { patient_id: <?php echo $patient_id; ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Date</th><th>Doctor</th><th>Status</th><th>Action</th></tr>';
                    response.appointments.forEach(function(apt) {
                        html += `<tr><td>${apt.appointment_date}</td><td>${apt.doctor_name}</td><td>${apt.status}</td><td><button class="cancel-apt" data-id="${apt.appointment_id}">Cancel</button></td></tr>`;
                    });
                    html += '</table>';
                    $('#appointments-list').html(html);
                } else {
                    $('#appointments-list').html('<p>No appointments.</p>');
                }
            }
        });

        $('#new-appointment').click(function() {
            // Placeholder for new appointment form (could be a modal)
            alert('New appointment form would go here.');
        });

        $(document).on('click', '.cancel-apt', function() {
            let aptId = $(this).data('id');
            if (confirm('Cancel this appointment?')) {
                $.ajax({
                    url: '../Action/manage_appointment.php',
                    type: 'POST',
                    data: { action: 'cancel', appointment_id: aptId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            }
        });
    });
    </script>
</body>
</html>