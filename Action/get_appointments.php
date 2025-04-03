<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['patient_id'])) {
        $patient_id = $_POST['patient_id'];
        $stmt = $pdo->prepare("
            SELECT a.appointment_id, a.appointment_date, d.full_name AS doctor_name, a.status
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.doctor_id
            WHERE a.patient_id = ? AND a.appointment_date >= NOW()
            ORDER BY a.appointment_date ASC
        ");
        $stmt->execute([$patient_id]);
    } elseif (isset($_POST['doctor_id'])) {
        $doctor_id = $_POST['doctor_id'];
        $stmt = $pdo->prepare("
            SELECT a.appointment_id, a.appointment_date, p.full_name AS patient_name, a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.patient_id
            WHERE a.doctor_id = ? AND a.appointment_date >= NOW()
            ORDER BY a.appointment_date ASC
        ");
        $stmt->execute([$doctor_id]);
    } elseif (isset($_POST['today'])) {
        $stmt = $pdo->prepare("
            SELECT a.appointment_date, p.full_name AS patient_name, d.full_name AS doctor_name, a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.patient_id
            JOIN doctors d ON a.doctor_id = d.doctor_id
            WHERE DATE(a.appointment_date) = CURDATE()
            ORDER BY a.appointment_date ASC
        ");
        $stmt->execute();
    }
} else {
    $stmt = $pdo->query("
        SELECT a.appointment_date, p.full_name AS patient_name, d.full_name AS doctor_name, a.status
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
        ORDER BY a.appointment_date ASC
    ");
}

$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['status' => $appointments ? 'success' : 'empty', 'appointments' => $appointments]);
?>