<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $data = [
        'patient_id' => $_POST['patient_id'],
        'doctor_id' => $_POST['doctor_id'],
        'rating' => $_POST['rating'],
        'comments' => $_POST['comments'] ?? null
    ];
    $stmt = $pdo->prepare("INSERT INTO feedback (patient_id, doctor_id, rating, comments) VALUES (?, ?, ?, ?)");
    if ($stmt->execute(array_values($data))) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Submission failed']);
    }
}
?>