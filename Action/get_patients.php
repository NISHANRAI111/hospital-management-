<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];
    $stmt = $pdo->prepare("
        SELECT DISTINCT p.full_name, p.age, p.blood_group
        FROM patients p
        JOIN appointments a ON p.patient_id = a.patient_id
        WHERE a.doctor_id = ?
    ");
    $stmt->execute([$doctor_id]);
} else {
    $stmt = $pdo->query("SELECT full_name, age, email FROM patients");
}

$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['status' => $patients ? 'success' : 'empty', 'patients' => $patients]);
?>