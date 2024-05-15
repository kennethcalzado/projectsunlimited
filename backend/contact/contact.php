<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Username = 'itsangelyne14@gmail.com'; // Your Gmail address
        $mail->Password = 'exspqwmbgyiqfvds'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // SMTP port

        // Recipients
        $mail->setFrom($email, $name); // Sender's email and name
        $mail->addAddress('info@projectsunlimited.com.ph', 'Do_Not_Reply'); // Recipient's email and name
        $mail->addReplyTo($email, $name); // Reply-to address

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New Inquiry from the website: $subject";
        $mail->Body = "
            <p>Good Day!</p>
            <p>$message</p>
            <p>I am hoping to receive feedback at your earliest convenience. You may contact me through my <b>Phone Number:$phone</b> or through my <b>Email: $email</b>.</p>
            <p>Thank You!</p>
            <p></p>
            <p>Best Regards,</p>
            <p>$name <br> $email</p>
        ";

        $mail->send();
        echo "Thank you! Your message has been sent.";
    } catch (Exception $e) {
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
}
?>
