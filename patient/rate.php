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
    <title>Rate - Patient Dashboard</title>
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
            <a href="billing.php">Billing and Payment</a>
            <a href="profile.php">Profile</a>
            <a class="active" href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="rate">
            <h1>Provide Feedback</h1>
            <form id="feedback-form">
                <label>Doctor: <select name="doctor_id">
                    <?php
                    $stmt = $pdo->query("SELECT doctor_id, full_name FROM doctors");
                    while ($doc = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$doc['doctor_id']}'>{$doc['full_name']}</option>";
                    }
                    ?>
                </select></label><br>
                <label>Rating (1-5): <input type="number" name="rating" min="1" max="5" required></label><br>
                <label>Comments: <textarea name="comments"></textarea></label><br>
                <button type="submit">Submit Feedback</button>
            </form>
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
        $('#feedback-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '../Action/submit_feedback.php',
                type: 'POST',
                data: $(this).serialize() + '&patient_id=<?php echo $patient_id; ?>',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Feedback submitted!');
                        $(this).trigger('reset');
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            });
        });
    });
    </script>
</body>
</html>