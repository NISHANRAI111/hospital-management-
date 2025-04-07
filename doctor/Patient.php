<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Doctor') {
    header("Location: /authorization/login.php");
    exit;
}
require_once '../database/database_connection.php';
$stmt = $pdo->prepare("SELECT doctor_id FROM doctors WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$doctor_id = $stmt->fetchColumn();
if ($doctor_id === false) {
    die("Error: No doctor ID found for this user.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Doctor Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
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
            <a href="home.php">Home</a>
            <a class="active" href="patient.php">Patients</a>
            <a href="appointments.php">Appointments</a>
            <a href="profile.php">Profile</a>
            <a href="report.php">Report</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="patient">
            <h1>Your Patients and Appointments</h1>
            <div id="patients-list"></div>
        </div>
    </section>
    <footer>
        <p>© 2025 MNMN | All Rights Reserved</p>
        <p>MNMN does not offer medical advice, diagnosis or treatment.</p>
        <p>The materials provided on our website, including services, content and products, are solely intended to provide informational purposes.</p>
    </footer>
    <script>
    $(document).ready(function() {
        $.ajax({
            url: '../Action/get_patients.php',
            type: 'POST',
            data: { doctor_id: <?php echo json_encode($doctor_id); ?> },
            dataType: 'json',
            success: function(response) {
                console.log(response); // Debug: Check the response
                if (response.status === 'success') {
                    let html = '<table><tr><th>Name</th><th>Age</th><th>Blood Group</th><th>Appointment Date</th><th>Status</th><th>Action</th><th>Reason</th></tr>';
                    response.patients.forEach(function(pat) {
                        html += `<tr>
                            <td>${pat.full_name}</td>
                            <td>${pat.age || 'N/A'}</td>
                            <td>${pat.blood_group || 'N/A'}</td>
                            <td>${pat.appointment_date || 'N/A'}</td>
                            <td>${pat.status || 'N/A'}</td>
                            <td>${pat.status === 'Pending' ? 
                                '<button class="approve-apt" data-id="' + pat.appointment_id + '">Approve</button><button class="reject-apt" data-id="' + pat.appointment_id + '">Reject</button>' : 
                                ''}</td>
                            <td>${pat.rejection_reason || 'N/A'}</td>
                        </tr>`;
                    });
                    html += '</table>';
                    $('#patients-list').html(html);
                } else {
                    $('#patients-list').html('<p>No patients or appointments.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });

        $(document).on('click', '.approve-apt', function() {
            let aptId = $(this).data('id');
            if (confirm('Approve this appointment?')) {
                $.ajax({
                    url: '../Action/manage_appointment.php',
                    type: 'POST',
                    data: { action: 'approve', appointment_id: aptId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') location.reload();
                        else alert('Error: ' + response.message);
                    }
                });
            }
        });

        $(document).on('click', '.reject-apt', function() {
            let aptId = $(this).data('id');
            let reason = prompt('Please provide a reason for rejection:');
            if (reason) {
                $.ajax({
                    url: '../Action/manage_appointment.php',
                    type: 'POST',
                    data: { action: 'reject', appointment_id: aptId, rejection_reason: reason },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') location.reload();
                        else alert('Error: ' + response.message);
                    }
                });
            } else if (reason === '') {
                alert('A reason is required for rejection.');
            }
        });
    });
    </script>
</body>
</html>