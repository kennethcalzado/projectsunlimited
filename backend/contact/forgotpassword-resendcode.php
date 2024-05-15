<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Include PHPMailer classes manually
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
include '../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Check if the email exists in the database
        $sql_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();
        $row_check_email = $result_check_email->fetch_assoc();

        if ($row_check_email['count'] == 0) {
            echo json_encode(['success' => false, 'message' => 'Email address not found']);
            exit;
        }

        // Generate a new verification code
        $verificationCode = mt_rand(100000, 999999);

        // Update the verification code in the database
        $sql_update_verification = "UPDATE verification_codes SET code = ?, created_at = NOW(), status = 'unused', entered_code = NULL WHERE email = ? ORDER BY created_at DESC LIMIT 1";
        $stmt_update_verification = $conn->prepare($sql_update_verification);
        $stmt_update_verification->bind_param("is", $verificationCode, $email);
        $stmt_update_verification->execute();

        // Close statement
        $stmt_update_verification->close();

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kyle.m.roperez@gmail.com';
        $mail->Password = 'nlxx qdcd kaoq dzsd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set sender email and name
        $mail->setFrom('kyle.m.roperez@gmail.com', 'Kyle'); // Replace with your email and name
        $mail->addAddress($email);

        // Style the email body with inline CSS
        $mail->isHTML(true);
        $mail->Subject = 'Resent Password Reset Verification Code - Projects Unlimited';
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
            <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
                <h2 style="color: #333;">Resent Password Reset Verification Code</h2>
                <p style="font-size: 16px; color: #555;">
                    You requested to resend the verification code to reset your password. Please use the following verification code to reset your password:
                </p>
                <div style="font-size: 24px; font-weight: bold; margin: 20px 0; text-align: center; color: #007BFF;">
                    ' . $verificationCode . '
                </div>
                <p style="font-size: 16px; color: #555;">
                    If you did not request a password reset, please ignore this email or contact support if you have questions.
                </p>
                <p style="font-size: 16px; color: #555;">
                    Thank you,<br>
                    Projects Unlimited.
                </p>
            </div>
        </div>';

        if ($mail->send()) {
            echo json_encode(['success' => true, 'message' => 'Verification code resent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error sending verification email: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No email address in session']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
