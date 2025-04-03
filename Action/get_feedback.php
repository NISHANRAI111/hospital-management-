<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];
    $stmt = $pdo->prepare("
        SELECT p.full_name AS patient_name, f.rating, f.comments
        FROM feedback f
        JOIN patients p ON f.patient_id = p.patient_id
        WHERE f.doctor_id = ?
    ");
    $stmt->execute([$doctor_id]);
} else {
    $stmt = $pdo->query("
        SELECT p.full_name AS patient_name, d.full_name AS doctor_name, f.rating, f.comments
        FROM feedback f
        JOIN patients p ON f.patient_id = p.patient_id
        JOIN doctors d ON f.doctor_id = d.doctor_id
    ");
}

$feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['status' => $feedback ? 'success' : 'empty', 'feedback' => $feedback]);
?>