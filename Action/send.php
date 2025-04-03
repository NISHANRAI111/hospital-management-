<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Only run when form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nishanhangr@gmail.com';
        $mail->Password   = 'wlsm xyjl oncx cofp'; // Use your actual app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Set sender and recipient
        $mail->setFrom($_POST["email"], $_POST["name"]);
        $mail->addAddress('nishanhangr@gmail.com');
        $mail->addReplyTo($_POST["email"], $_POST["name"]);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body    = nl2br(htmlspecialchars($_POST["message"])); // Escape and format line breaks

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "error";
    }
} else {
    echo "invalid";
}
?>
