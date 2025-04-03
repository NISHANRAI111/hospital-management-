<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Patient') {
    header("Location: /authorization/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Patient Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/icon.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/icon.webp" alt="Hospital Logo">
            <h2>Patient Dashboard</h2>
        </div>
        <form action="../Action/logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </header>
    <section class="main">
        <aside class="ver-nav-bar">
            <a class="active" href="home.php">Home</a>
            <a href="doctor.php">Doctors</a>
            <a href="appointments.php">Appointments</a>
            <a href="billing.php">Billing and Payment</a>
            <a href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="home">
            <h1>Welcome to Your Patient Dashboard</h1>
            <p>Here you can manage your appointments, view doctor information, and handle billing.</p>
            <!-- Example: Display upcoming appointments -->
            <h2>Upcoming Appointments</h2>
            <div id="appointments-list">
                <!-- Appointments will be loaded via AJAX -->
            </div>
        </div>
    </section>
    <footer>
        <p>© 2025 MNMN | All Rights Reserved</p>
        <p>Healthroid does not offer medical advice, diagnosis or treatment.</p>
        <p>The materials provided on our website, including services, content and products, are solely intended to provide informational purposes.</p>
        <p>Created and Designed by Manoj KC and Nishan Rai</p>
    </footer>


</body>

</html>