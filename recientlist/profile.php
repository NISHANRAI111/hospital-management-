<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Receptionist') {
    header("Location: /authorization/login.php");
    exit;
}
require_once '../database/database_connection.php';
$stmt = $pdo->prepare("SELECT full_name, age, email, work_shift FROM receptionists WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Receptionist Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo"><img src="../assets/icon.webp" alt="Hospital Logo"><h2>Receptionist Dashboard</h2></div>
        <form action="../Action/logout.php" method="post"><button type="submit">Logout</button></form>
    </header>
    <section class="main">
        <aside class="ver-nav-bar">
            <a href="home.php">Home</a>
            <a href="patient.php">Patient</a>
            <a href="report.php">Report</a>
            <a class="active" href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="profile">
            <h1>Your Profile</h1>
            <form id="profile-form">
                <label>Full Name: <input type="text" name="full_name" value="<?php echo htmlspecialchars($profile['full_name']); ?>" required></label><br>
                <label>Age: <input type="number" name="age" value="<?php echo $profile['age']; ?>"></label><br>
                <label>Email: <input type="email" name="email" value="<?php echo $profile['email']; ?>"></label><br>
                <label>Work Shift: <select name="work_shift">
                    <?php foreach (['Morning', 'Evening', 'Night'] as $shift) {
                        echo "<option value='$shift'" . ($profile['work_shift'] === $shift ? ' selected' : '') . ">$shift</option>";
                    } ?>
                </select></label><br>
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
                data: $(this).serialize() + '&user_id=<?php echo $_SESSION['user_id']; ?>&role=Receptionist',
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