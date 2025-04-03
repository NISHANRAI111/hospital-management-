<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

$stmt = $pdo->query("SELECT user_id, full_name, specialization, years_of_experience FROM doctors");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status' => $doctors ? 'success' : 'empty', 'doctors' => $doctors]);
?>