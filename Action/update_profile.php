<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['role'])) {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $table = strtolower($role) . 's';

    if ($role === 'Patient') {
        $fields = ['full_name', 'age', 'email', 'medical_history', 'blood_group', 'emergency_contact'];
    } elseif ($role === 'Doctor') {
        $fields = ['full_name', 'age', 'email', 'specialization', 'years_of_experience', 'medical_license_number'];
    } elseif ($role === 'Receptionist') {
        $fields = ['full_name', 'age', 'email', 'work_shift'];
    } elseif ($role === 'Admin') {
        $fields = ['full_name'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
        exit;
    }

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $_POST[$field] ?? null;
    }
    $placeholders = implode(', ', array_map(fn($f) => "$f = ?", $fields));
    $stmt = $pdo->prepare("UPDATE $table SET $placeholders WHERE user_id = ?");
    if ($stmt->execute([...array_values($data), $user_id])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
}
?>