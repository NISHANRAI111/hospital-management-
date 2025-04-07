<?php
header('Content-Type: application/json');
require_once '../database/database_connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method or missing action']);
        exit;
    }

    $action = $_POST['action'];

    if ($action === 'create' && isset($_POST['patient_id'], $_POST['doctor_id'], $_POST['appointment_date'])) {
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];

        // Validate doctor exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM doctors WHERE doctor_id = ?");
        $stmt->execute([$doctor_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid doctor ID']);
            exit;
        }

        // Validate patient exists (optional, added for robustness)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM patients WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid patient ID']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO appointments (patient_id, doctor_id, appointment_date, status)
            VALUES (?, ?, ?, 'Pending')
        ");
        $stmt->execute([$patient_id, $doctor_id, $appointment_date]);
        echo json_encode(['status' => 'success', 'message' => 'Appointment created']);
    } elseif ($action === 'cancel' && isset($_POST['appointment_id'])) {
        $appointment_id = $_POST['appointment_id'];
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'Cancelled' WHERE appointment_id = ?");
        $stmt->execute([$appointment_id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Appointment cancelled']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Appointment not found']);
        }
    } elseif ($action === 'approve' && isset($_POST['appointment_id'])) {
        $appointment_id = $_POST['appointment_id'];
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'Confirmed' WHERE appointment_id = ?");
        $stmt->execute([$appointment_id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Appointment approved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Appointment not found']);
        }
    } elseif ($action === 'reject' && isset($_POST['appointment_id'], $_POST['rejection_reason'])) {
        $appointment_id = $_POST['appointment_id'];
        $rejection_reason = $_POST['rejection_reason'];
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'Rejected', rejection_reason = ? WHERE appointment_id = ?");
        $stmt->execute([$rejection_reason, $appointment_id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Appointment rejected']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Appointment not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing parameters']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>