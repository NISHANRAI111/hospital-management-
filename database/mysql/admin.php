<?php
// Database connection
$host = 'localhost';
$dbname = 'mnmn_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Admin details to add
    $admin_username = 'admin123';
    $admin_password = 'password123'; // This will be hashed
    $full_name = 'Manoj_Nishan';
    
    // Start transaction since we need to insert into two tables
    $pdo->beginTransaction();
    
    // 1. Insert into users table
    $password_hash = password_hash($admin_password, PASSWORD_DEFAULT);
    $sql_users = "INSERT INTO users (username, password_hash, role, is_admin) 
                  VALUES (:username, :password_hash, 'Admin', 1)";
    
    $stmt_users = $pdo->prepare($sql_users);
    $stmt_users->execute([
        ':username' => $admin_username,
        ':password_hash' => $password_hash
    ]);
    
    // Get the last inserted user_id
    $user_id = $pdo->lastInsertId();
    
    // 2. Insert into admins table
    $sql_admins = "INSERT INTO admins (user_id, full_name) 
                   VALUES (:user_id, :full_name)";
    
    $stmt_admins = $pdo->prepare($sql_admins);
    $stmt_admins->execute([
        ':user_id' => $user_id,
        ':full_name' => $full_name
    ]);
    
    // Commit the transaction
    $pdo->commit();
    
    echo "Admin added successfully! User ID: " . $user_id;
    
} catch (PDOException $e) {
    // Roll back the transaction if something fails
    $pdo->rollBack();
    echo "Error adding admin: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>