<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: /authorization/login.php");
    exit;
}
require_once '../database/database_connection.php';
$patient_id = $pdo->query("SELECT patient_id FROM patients WHERE user_id = " . $_SESSION['user_id'])->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - Patient Dashboard</title>
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
            <a href="appointments.php">Appointments</a>
            <a class="active" href="billing.php">Billing and Payment</a>
            <a href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="billing">
            <h1>Your Bills</h1>
            <div id="billing-list"></div>
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
            data: { patient_id: <?php echo $patient_id; ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Amount</th><th>Due Date</th><th>Status</th><th>Action</th></tr>';
                    response.bills.forEach(function(bill) {
                        html += `<tr><td>$${bill.total_amount}</td><td>${bill.due_date}</td><td>${bill.payment_status}</td><td>${bill.payment_status === 'Pending' ? '<button class="pay-bill" data-id="' + bill.bill_id + '">Pay</button>' : ''}</td></tr>`;
                    });
                    html += '</table>';
                    $('#billing-list').html(html);
                } else {
                    $('#billing-list').html('<p>No bills.</p>');
                }
            }
        });

        $(document).on('click', '.pay-bill', function() {
            let billId = $(this).data('id');
            if (confirm('Pay this bill?')) {
                $.ajax({
                    url: '../Action/pay_bill.php',
                    type: 'POST',
                    data: { bill_id: billId },
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