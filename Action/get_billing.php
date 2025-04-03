<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['patient_id'])) {
        $patient_id = $_POST['patient_id'];
        $stmt = $pdo->prepare("SELECT bill_id, total_amount, due_date, payment_status FROM billing WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
    } elseif (isset($_POST['doctor_id'])) {
        $doctor_id = $_POST['doctor_id'];
        $stmt = $pdo->prepare("
            SELECT b.bill_id, b.total_amount, b.payment_status, p.full_name AS patient_name
            FROM billing b
            JOIN medical_records mr ON mr.patient_id = b.patient_id
            JOIN patients p ON p.patient_id = b.patient_id
            WHERE mr.doctor_id = ?
        ");
        $stmt->execute([$doctor_id]);
    }
} else {
    $stmt = $pdo->query("
        SELECT b.total_amount, b.payment_status, p.full_name AS patient_name
        FROM billing b
        JOIN patients p ON b.patient_id = p.patient_id
    ");
}

$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['status' => $bills ? 'success' : 'empty', 'bills' => $bills]);
?>