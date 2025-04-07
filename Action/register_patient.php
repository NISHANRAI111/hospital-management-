<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'] ?? '';
    $age = $_POST['age'] ?: null;
    $email = $_POST['email'] ?: null;
    $blood_group = $_POST['blood_group'] ?: null;
    $emergency_contact = $_POST['emergency_contact'] ?: null;

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, 'Patient')");
        $stmt->execute([$username, $password]);
        $user_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO patients (user_id, full_name, age, email, blood_group, emergency_contact) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $full_name, $age, $email, $blood_group, $emergency_contact]);

        $pdo->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>