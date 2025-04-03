<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bill_id'])) {
    $bill_id = $_POST['bill_id'];
    $stmt = $pdo->prepare("UPDATE billing SET payment_status = 'Paid', payment_date = NOW() WHERE bill_id = ? AND payment_status = 'Pending'");
    if ($stmt->execute([$bill_id])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Payment failed']);
    }
}
?>