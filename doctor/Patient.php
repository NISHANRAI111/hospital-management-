
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
        <div class="logo"><img src="../assets/icon.webp" alt="Hospital Logo"><h2>Doctor Dashboard</h2></div>
        <form action="../Action/logout.php" method="post"><button type="submit">Logout</button></form>
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
            <h1>Your Patients</h1>
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
        $.ajax({
            url: '../Action/get_patients.php',
            type: 'POST',
            data: { doctor_id: <?php echo $pdo->query("SELECT doctor_id FROM doctors WHERE user_id = " . $_SESSION['user_id'])->fetchColumn(); ?> },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let html = '<table><tr><th>Name</th><th>Age</th><th>Blood Group</th></tr>';
                    response.patients.forEach(function(pat) {
                        html += `<tr><td>${pat.full_name}</td><td>${pat.age || 'N/A'}</td><td>${pat.blood_group || 'N/A'}</td></tr>`;
                    });
                    html += '</table>';
                    $('#patients-list').html(html);
                } else {
                    $('#patients-list').html('<p>No patients.</p>');
                }
            }
        });
    });
    </script>
</body>
</html>