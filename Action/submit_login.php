<?php
ini_set('display_errors', 0); // Disable in production
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/error.log');
error_reporting(E_ALL);

require '../database/database_connection.php';

header('Content-Type: application/json');

session_start();

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

try {
    if (!isset($pdo)) {
        throw new PDOException("Database connection not established");
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    $errors = [];
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }
    if (empty($role) || !in_array($role, ['Patient', 'Doctor', 'Receptionist', 'Admin'])) {
        $errors['role'] = "Please select a valid role";
    }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "errors" => $errors]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = :username AND role = :role");
    $stmt->execute([
        'username' => $username,
        'role' => $role
    ]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        echo json_encode(["status" => "error", "errors" => ["general" => "Invalid username, password, or role"]]);
        exit;
    }

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    $redirect = '';
    switch ($user['role']) {
        case 'Patient':
            $redirect = '../patient/home.php';
            break;
        case 'Doctor':
            $redirect = '../doctor/home.php';
            break;
        case 'Receptionist':
            $redirect = '../recientlist/home.php';
            break;
        case 'Admin':
            $redirect = '../admin/home.php';
            break;
        default:
            $redirect = '../authorization/login.php';
    }

    echo json_encode([
        "status" => "success",
        "message" => "Login successful!",
        "redirect" => $redirect
    ]);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "A database error occurred. Please try again later."]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "An error occurred. Please try again later."]);
}
?>