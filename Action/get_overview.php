<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

$data = [
    'patients' => $pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn(),
    'doctors' => $pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn(),
    'appointments' => $pdo->query("SELECT COUNT(*) FROM appointments WHERE appointment_date >= NOW()")->fetchColumn(),
    'pending_bills' => $pdo->query("SELECT COUNT(*) FROM billing WHERE payment_status = 'Pending'")->fetchColumn()
];

echo json_encode(['status' => 'success', 'patients' => $data['patients'], 'doctors' => $data['doctors'], 'appointments' => $data['appointments'], 'pending_bills' => $data['pending_bills']]);
?>