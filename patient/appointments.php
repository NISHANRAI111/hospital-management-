<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: /authorization/login.php");
    exit;
}

// Debug file path
if (!file_exists('../database/database_connection.php')) {
    die("Error: database_connection.php not found at " . realpath('../database/database_connection.php'));
}
require_once '../database/database_connection.php';

// Use prepared statement to prevent SQL injection
$stmt = $pdo->prepare("SELECT patient_id FROM patients WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$patient_id = $stmt->fetchColumn();
if ($patient_id === false) {
    die("Error: No patient ID found for this user.");
}
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
        // Fetch existing appointments
        $.ajax({
            url: '../Action/get_appointments.php',
            type: 'POST',
            data: { patient_id: <?php echo json_encode($patient_id); ?> },
            dataType: 'json',
            success: function(response) {
                console.log(response);
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
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });

        // Handle "Request New Appointment" button click
        $('#new-appointment').click(function() {
            // Show a simple form (you can style this with CSS or use a modal)
            let formHtml = `
                <div id="appointment-form">
                    <h3>Request New Appointment</h3>
                    <label>Doctor ID: <input type="number" id="doctor_id" required></label><br>
                    <label>Date and Time: <input type="datetime-local" id="appointment_date" required></label><br>
                    <button id="submit-appointment">Submit</button>
                    <button id="cancel-form">Cancel</button>
                </div>`;
            $('#appointments-list').append(formHtml);
            $(this).hide(); // Hide the "Request New Appointment" button while form is visible
        });

        // Handle form submission
        $(document).on('click', '#submit-appointment', function() {
            let doctorId = $('#doctor_id').val();
            let appointmentDate = $('#appointment_date').val();

            if (doctorId && appointmentDate) {
                $.ajax({
                    url: '../Action/manage_appointment.php',
                    type: 'POST',
                    data: {
                        action: 'create',
                        patient_id: <?php echo json_encode($patient_id); ?>,
                        doctor_id: doctorId,
                        appointment_date: appointmentDate
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Appointment requested successfully!');
                            location.reload(); // Refresh to show the new appointment
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                    }
                });
            } else {
                alert('Please fill in all fields.');
            }
        });

        // Cancel form
        $(document).on('click', '#cancel-form', function() {
            $('#appointment-form').remove();
            $('#new-appointment').show();
        });

        // Handle appointment cancellation
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