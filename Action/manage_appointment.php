<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $appointment_id = $_POST['appointment_id'] ?? '';

    if ($action === 'cancel') {
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id = ? AND status = 'Pending'");
        $success = $stmt->execute([$appointment_id]);
    } elseif ($action === 'approve') {
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'Accepted' WHERE appointment_id = ? AND status = 'Pending'");
        $success = $stmt->execute([$appointment_id]);
    } elseif ($action === 'reject') {
        $reason = $_POST['rejection_reason'] ?? '';
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'Rejected', rejection_reason = ? WHERE appointment_id = ? AND status = 'Pending'");
        $success = $stmt->execute([$reason, $appointment_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        exit;
    }

    echo json_encode(['status' => $success ? 'success' : 'error', 'message' => $success ? '' : 'Action failed']);
}
?>