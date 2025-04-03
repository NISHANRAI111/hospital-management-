<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Receptionist') {
    header("Location: /authorization/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient - Receptionist Dashboard</title>
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
            <a class="active" href="patient.php">Patient</a>
            <a href="report.php">Report</a>
            <a href="profile.php">Profile</a>
            <a href="rate.php">Rate</a>
        </aside>
        <div class="main-content" id="patient">
            <h1>Register New Patient</h1>
            <form id="register-patient-form">
                <label>Username: <input type="text" name="username" required></label><br>
                <label>Password: <input type="password" name="password" required></label><br>
                <label>Full Name: <input type="text" name="full_name" required></label><br>
                <label>Age: <input type="number" name="age"></label><br>
                <label>Email: <input type="email" name="email"></label><br>
                <label>Blood Group: <select name="blood_group">
                    <option value="">Select</option>
                    <?php foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg) {
                        echo "<option value='$bg'>$bg</option>";
                    } ?>
                </select></label><br>
                <label>Emergency Contact: <input type="text" name="emergency_contact"></label><br>
                <button type="submit">Register</button>
            </form>
            <h2>Patient List</h2>
            <div id="patients-list"></div>
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
        // Load patient list
        $.ajax({
            url: '../Action/get_patients.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Name</th><th>Age</th><th>Email</th></tr>';
                    response.patients.forEach(function(pat) {
                        html += `<tr><td>${pat.full_name}</td><td>${pat.age || 'N/A'}</td><td>${pat.email || 'N/A'}</td></tr>`;
                    });
                    html += '</table>';
                    $('#patients-list').html(html);
                } else {
                    $('#patients-list').html('<p>No patients.</p>');
                }
            }
        });

        // Register new patient
        $('#register-patient-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '../Action/register_patient.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Patient registered!');
                        location.reload();
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