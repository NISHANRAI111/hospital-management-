<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: /authorization/login.php");
    exit;
}
require_once '../database/database_connection.php';
$stmt = $pdo->prepare("SELECT full_name, age, email, medical_history, blood_group, emergency_contact FROM patients WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Patient Dashboard</title>
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
            <a class="active" href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="profile">
            <h1>Your Profile</h1>
            <form id="profile-form">
                <label>Full Name: <input type="text" name="full_name" value="<?php echo htmlspecialchars($profile['full_name']); ?>"></label><br>
                <label>Age: <input type="number" name="age" value="<?php echo $profile['age']; ?>"></label><br>
                <label>Email: <input type="email" name="email" value="<?php echo $profile['email']; ?>"></label><br>
                <label>Medical History: <textarea name="medical_history"><?php echo htmlspecialchars($profile['medical_history']); ?></textarea></label><br>
                <label>Blood Group: <select name="blood_group">
                    <?php foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg) {
                        echo "<option value='$bg'" . ($profile['blood_group'] === $bg ? ' selected' : '') . ">$bg</option>";
                    } ?>
                </select></label><br>
                <label>Emergency Contact: <input type="text" name="emergency_contact" value="<?php echo $profile['emergency_contact']; ?>"></label><br>
                <button type="submit">Update Profile</button>
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
        $('#profile-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '../Action/update_profile.php',
                type: 'POST',
                data: $(this).serialize() + '&user_id=<?php echo $_SESSION['user_id']; ?>',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Profile updated successfully!');
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