<?php
ini_set('display_errors', 1); // Enable error reporting for debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../database/database_connection.php'; // Database connection

header('Content-Type: application/json');

try {
    // Ensure $pdo is available and configured
    if (!isset($pdo)) {
        throw new PDOException("Database connection not established");
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve and sanitize form data
    $fullname = trim($_POST['fullname'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';

    // Validate required fields
    $errors = [];
    if (empty($fullname)) $errors['fullname'] = "Full name is required";
    if ($age < 1 || $age > 150) $errors['age'] = "Age must be between 1 and 150";
    if (empty($username) || strlen($username) < 3) $errors['username'] = "Username must be at least 3 characters";
    if (empty($password)) $errors['password'] = "Password is required";
    elseif ($password !== $confirm_password) $errors['confirm_password'] = "Passwords do not match";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Valid email is required";
    if (!in_array($role, ['Patient', 'Doctor', 'Receptionist'])) $errors['role'] = "Please select a valid role";

    // Role-specific validations
    if ($role === 'Doctor') {
        $specialization = trim($_POST['specialization'] ?? '');
        $experience = intval($_POST['experience'] ?? 0);
        $license = trim($_POST['license'] ?? '');
        if (empty($specialization)) $errors['specialization'] = "Specialization is required for doctors";
        if (empty($license)) $errors['license'] = "Medical license number is required";
    } elseif ($role === 'Receptionist') {
        $shift = trim($_POST['shift'] ?? '');
        if (empty($shift) || !in_array($shift, ['Morning', 'Evening', 'Night'])) {
            $errors['shift'] = "Please select a valid work shift";
        }
    }

    // Check if username already exists
    if (empty($errors['username'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $errors['username'] = "Username is already taken";
        }
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "errors" => $errors]);
        exit;
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Begin transaction
    $pdo->beginTransaction();

    // Insert into users table
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (:username, :password, :role)");
    $stmt->execute([
        'username' => $username,
        'password' => $password_hash,
        'role' => $role
    ]);

    $user_id = $pdo->lastInsertId();

    // Insert into specific role table
    if ($role === 'Patient') {
        $medical_history = trim($_POST['medical-history'] ?? '');
        $blood_group = trim($_POST['blood-group'] ?? '');
        $contact = trim($_POST['contact'] ?? '');
        $stmt = $pdo->prepare("INSERT INTO patients (user_id, full_name, age, email, medical_history, blood_group, emergency_contact) 
                                VALUES (:user_id, :full_name, :age, :email, :medical_history, :blood_group, :contact)");
        $stmt->execute([
            'user_id' => $user_id,
            'full_name' => $fullname,
            'age' => $age,
            'email' => $email,
            'medical_history' => $medical_history,
            'blood_group' => $blood_group,
            'contact' => $contact
        ]);
    } elseif ($role === 'Doctor') {
        $specialization = trim($_POST['specialization'] ?? '');
        $experience = intval($_POST['experience'] ?? 0);
        $license = trim($_POST['license'] ?? '');
        $stmt = $pdo->prepare("INSERT INTO doctors (user_id, full_name, age, email, specialization, years_of_experience, medical_license_number) 
                                VALUES (:user_id, :full_name, :age, :email, :specialization, :experience, :license)");
        $stmt->execute([
            'user_id' => $user_id,
            'full_name' => $fullname,
            'age' => $age,
            'email' => $email,
            'specialization' => $specialization,
            'experience' => $experience,
            'license' => $license
        ]);
    } elseif ($role === 'Receptionist') {
        $shift = trim($_POST['shift'] ?? '');
        $stmt = $pdo->prepare("INSERT INTO receptionists (user_id, full_name, age, email, work_shift) 
                                VALUES (:user_id, :full_name, :age, :email, :shift)");
        $stmt->execute([
            'user_id' => $user_id,
            'full_name' => $fullname,
            'age' => $age,
            'email' => $email,
            'shift' => $shift
        ]);
    }

    $pdo->commit();
    // Return success with a redirect instruction
    echo json_encode([
        "status" => "success",
        "message" => "Registration successful!",
        "redirect" => "login.php"
    ]);
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
}
?>