<?php

require_once '../database/database_connection.php';
$doctor_id = $pdo->query("SELECT doctor_id FROM doctors WHERE user_id = " . $_SESSION['user_id'])->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report - Doctor Dashboard</title>
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
            <a class="active" href="report.php">Report</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="report">
            <h1>Your Reports</h1>
            <div id="report-list"></div>
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
            url: '../Action/get_billing.php',
            type: 'POST',
            data: { doctor_id: <?php echo $doctor_id; ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Patient</th><th>Amount</th><th>Status</th></tr>';
                    response.bills.forEach(function(bill) {
                        html += `<tr><td>${bill.patient_name}</td><td>$${bill.total_amount}</td><td>${bill.payment_status}</td></tr>`;
                    });
                    html += '</table>';
                    $('#report-list').html(html);
                } else {
                    $('#report-list').html('<p>No billing reports.</p>');
                }
            }
        });
    });
    </script>
</body>
</html>