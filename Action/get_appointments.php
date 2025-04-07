<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];
    $stmt = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, d.full_name AS doctor_name, a.status
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.doctor_id
        WHERE a.patient_id = ? AND a.appointment_date >= NOW()
        ORDER BY a.appointment_date ASC
    ");
    $stmt->execute([$patient_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => $appointments ? 'success' : 'empty', 'appointments' => $appointments]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>