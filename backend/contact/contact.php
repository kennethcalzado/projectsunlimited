<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes manually
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'itsangelyne14@gmail.com'; // Your Gmail address
        $mail->Password = 'exspqwmbgyiqfvds'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // SMTP port

        // Recipients
        $mail->setFrom($email, $name); // Sender's email and name
        $mail->addAddress('itsangelyne14@gmail.com', 'Angelyne'); // Recipient's email and name

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New Inquiry from the website: $subject";
        $mail->Body = "
            <p><strong style='font-weight: 600;'>Inquirer:</strong> $name</p>
            <p><strong style='font-weight: 600;'>Email:</strong> $email</p>
            <p><strong style='font-weight: 600;'>Contact Number:</strong> $phone</p>
            <p><strong style='font-weight: 600;'>Concern/Inquiry:</strong> $message</p>
        ";

        $mail->send();
        echo "Thank you! Your message has been sent.";
    } catch (Exception $e) {
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
}
?>
