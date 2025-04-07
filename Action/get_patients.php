<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctor_id'])) {
        $doctor_id = $_POST['doctor_id'];
        
        // Fetch patients and their upcoming appointments
        $stmt = $pdo->prepare("
            SELECT p.full_name, p.age, p.blood_group, 
                   a.appointment_id, a.appointment_date, a.status, a.rejection_reason
            FROM patients p
            JOIN appointments a ON p.patient_id = a.patient_id
            WHERE a.doctor_id = ? AND a.appointment_date >= NOW()
            ORDER BY a.appointment_date ASC
        ");
        $stmt->execute([$doctor_id]);
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return patients or an empty status
        echo json_encode([
            'status' => $patients ? 'success' : 'empty',
            'patients' => $patients
        ]);
    } else {
        // Invalid request handling
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method or missing doctor_id'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>