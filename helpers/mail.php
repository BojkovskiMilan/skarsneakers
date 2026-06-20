<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendActivationEmail($toEmail, $activationLink)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'milan.bojkovski.9.22@ict.edu.rs';
        $mail->Password = 'rzcf ciwx yhhr wqxx';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('milan.bojkovski.9.22@ict.edu.rs', 'Skar Sneakers');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Activate your Skar Sneakers account';

        $mail->Body = "
            <h2>Welcome to Skar Sneakers</h2>
            <p>Click the link below to activate your account:</p>
            <a href='$activationLink'>Activate Account</a>
        ";

        $mail->send();

        return true;

    } catch (Exception $e) {
        return false;
    }
}