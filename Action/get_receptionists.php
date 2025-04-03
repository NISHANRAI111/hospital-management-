<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

$stmt = $pdo->query("SELECT user_id, full_name, age, work_shift FROM receptionists");
$receptionists = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status' => $receptionists ? 'success' : 'empty', 'receptionists' => $receptionists]);
?>