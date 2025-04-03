
require_once '../database/database_connection.php';
$doctor_id = $pdo->query("SELECT doctor_id FROM doctors WHERE user_id = " . $_SESSION['user_id'])->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Doctor Dashboard</title>
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
            <a class="active" href="appointments.php">Appointments</a>
            <a href="profile.php">Profile</a>
            <a href="report.php">Report</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="appointments">
            <h1>Your Appointments</h1>
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
            data: { doctor_id: <?php echo $doctor_id; ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Date</th><th>Patient</th><th>Status</th><th>Action</th></tr>';
                    response.appointments.forEach(function(apt) {
                        html += `<tr><td>${apt.appointment_date}</td><td>${apt.patient_name}</td><td>${apt.status}</td><td>${apt.status === 'Pending' ? '<button class="approve-apt" data-id="' + apt.appointment_id + '">Approve</button><button class="reject-apt" data-id="' + apt.appointment_id + '">Reject</button>' : ''}</td></tr>`;
                    });
                    html += '</table>';
                    $('#appointments-list').html(html);
                } else {
                    $('#appointments-list').html('<p>No appointments.</p>');
                }
            }
        });

        $(document).on('click', '.approve-apt', function() {
            let aptId = $(this).data('id');
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
        });

        $(document).on('click', '.reject-apt', function() {
            let aptId = $(this).data('id');
            let reason = prompt('Reason for rejection:');
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
            }
        });
    });
    </script>
</body>
</html>