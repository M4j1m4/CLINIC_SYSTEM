<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

$conn = new mysqli('localhost', 'root', '', 'clinic_data');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $recipient = $data['email'];
    $subject = $data['subject'];
    $message = $data['message'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'GMAIL NG SENDER;'; 
        $mail->Password = 'APP PASSWORD NG SENDER'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('EMAIL NG SENDER', 'NAME NG SENDER');
        $mail->addAddress($recipient);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        $status = 'success';
        echo json_encode(['status' => 'Email sent successfully']);
    } catch (Exception $e) {
        $status = 'failed';
        echo json_encode(['status' => 'Email could not be sent. Error: ' . $mail->ErrorInfo]);
    }

   
    $stmt = $conn->prepare("INSERT INTO email_logs (recipient_email, subject, message, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $recipient, $subject, $message, $status);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
