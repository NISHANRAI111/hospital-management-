<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="../Action/submit_registration.php" method="post">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                <small class="error fullerror">Invalid full name</small>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="150" required>
                <small class="error ageerror">Invalid age</small>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Set your username" required>
                <small class="error usererror">Invalid username</small>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Set your password" required>
                <small class="error passerror">Password must be 8-16 characters with uppercase, lowercase, number, and special character</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                <small class="error cnerror">Passwords do not match</small>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <small class="error emailerror">Invalid email</small>
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
                </div>
                <small class="error roleerror">Please select a role</small>
            </fieldset>

            <div id="Patient-fields" class="role-section">
                <h3>Patient Details</h3>
                <label for="medical-history">Medical History:</label>
                <textarea id="medical-history" name="medical-history" placeholder="Enter medical history"></textarea>
                <label for="blood-group">Blood Group:</label>
                <select id="blood-group" name="blood-group">
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
                <label for="contact">Emergency Contact:</label>
                <input type="tel" id="contact" name="contact" placeholder="Enter emergency contact number">
            </div>

            <div id="Doctor-fields" class="role-section">
                <h3>Doctor Details</h3>
                <label for="specialization">Specialization:</label>
                <input type="text" id="specialization" name="specialization" placeholder="Enter specialization">
                <label for="experience">Years of Experience:</label>
                <input type="number" id="experience" name="experience" placeholder="Enter years of experience" min="0">
                <label for="license">Medical License Number:</label>
                <input type="text" id="license" name="license" placeholder="Enter license number">
            </div>

            <div id="Receptionist-fields" class="role-section">
                <h3>Receptionist Details</h3>
                <label for="shift">Work Shift:</label>
                <select id="shift" name="shift">
                    <option value="">Select Shift</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                    <option value="Night">Night</option>
                </select>
            </div>

            <button type="submit">Register</button>
        </form>
        <a href="login.php">
            <p>Already registered? Login here</p>
        </a>
    </div>
    <script>
        $(document).ready(function() {
            // Function to toggle role-specific fields
            function toggleRoleFields() {
                $(".role-section").hide();
                let selectedRole = $("input[name='role']:checked").val();
                if (selectedRole) {
                    $("#" + selectedRole + "-fields").show();
                }
            }

            $("input[name='role']").change(toggleRoleFields);
            toggleRoleFields();
            $(".error").hide();

            // Function to validate form inputs (client-side)
            function validateRegister() {
                let isValid = true;
                const fullname = $("#fullname").val().trim();
                const age = $("#age").val().trim();
                const username = $("#username").val().trim();
                const password = $("#password").val().trim();
                const confirmPassword = $("#confirm_password").val().trim();
                const email = $("#email").val().trim();

                const passPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_\+=]).{8,16}$/;
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                const namePattern = /^[a-zA-Z\s]{2,}$/;

                $(".error").hide();

                if (!fullname.match(namePattern)) {
                    $(".fullerror").slideDown();
                    isValid = false;
                }
                if (age === "" || age < 1 || age > 150) {
                    $(".ageerror").slideDown();
                    isValid = false;
                }
                if (username.length < 3) {
                    $(".usererror").slideDown();
                    isValid = false;
                }
                if (!password.match(passPattern)) {
                    $(".passerror").slideDown();
                    isValid = false;
                }
                if (confirmPassword !== password) {
                    $(".cnerror").slideDown();
                    isValid = false;
                }
                if (!email.match(emailPattern)) {
                    $(".emailerror").slideDown();
                    isValid = false;
                }
                if (!$("input[name='role']:checked").val()) {
                    $(".roleerror").slideDown();
                    isValid = false;
                }

                return isValid;
            }

            // Form submission
            $("form").submit(function(e) {
                e.preventDefault();
                $(".error").hide();

                if (!validateRegister()) {
                    return;
                }

                $.ajax({
                    url: "../Action/submit_registration.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "error") {
                            if (response.errors) {
                                for (const field in response.errors) {
                                    $(`.${field}error`).text(response.errors[field]).slideDown();
                                }
                            } else {
                                alert(response.message || "An error occurred during registration");
                            }
                        } else {
                            // Check for redirect instruction and perform it
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                alert(response.message || "Registration successful, but no redirect specified.");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", {
                            status,
                            error,
                            responseText: xhr.responseText
                        });
                        let errorMsg = "An error occurred. Please try again.";
                        if (xhr.status === 404) {
                            errorMsg = "Registration script not found.";
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