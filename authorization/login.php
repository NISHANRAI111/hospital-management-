<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                <small class="error username-error">Please enter a valid username</small>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <small class="error password-error">Please enter a valid password</small>
            </div>

            <fieldset>
                <legend>Select Role:</legend>
                <div class="radio-group">
                    <div>
                        <input type="radio" id="patient" name="role" value="Patient" required>
                        <label for="patient">Patient</label>
                    </div>
                    <div>
                        <input type="radio" id="doctor" name="role" value="Doctor">
                        <label for="doctor">Doctor</label>
                    </div>
                    <div>
                        <input type="radio" id="receptionist" name="role" value="Receptionist">
                        <label for="receptionist">Receptionist</label>
                    </div>
                    <div>
                        <input type="radio" id="admin" name="role" value="Admin">
                        <label for="admin">Admin</label>
                    </div>
                </div>
                <small class="error role-error">Please select a role</small>
            </fieldset>

            <button type="submit">Login</button>
        </form>
        <a href="register.php"><p>Not registered yet? Register here</p></a>
    </div>

    <script>
        $(document).ready(function() {
            $(".error").hide();

            $("#loginForm").submit(function(e) {
                e.preventDefault();
                $(".error").hide();

                $.ajax({
                    url: "../Action/submit_login.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "error") {
                            if (response.errors) {
                                for (const field in response.errors) {
                                    if (field === "general") {
                                        alert(response.errors[field]);
                                    } else {
                                        $(`.${field}-error`).text(response.errors[field]).slideDown();
                                    }
                                }
                            } else {
                                alert(response.message || "An error occurred during login");
                            }
                        } else {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                alert(response.message || "Login successful, but no redirect specified.");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", { status, error, responseText: xhr.responseText });
                        let errorMsg = "An error occurred. Please try again.";
                        if (xhr.status === 404) {
                            errorMsg = "Login script not found.";
                        } else if (xhr.status === 500) {
                            errorMsg = "Server error: " + (xhr.responseText || "Please contact support.");
                        }
                        alert(errorMsg);
                    }
                });
            });
        });
    </script>
</body>
</html>