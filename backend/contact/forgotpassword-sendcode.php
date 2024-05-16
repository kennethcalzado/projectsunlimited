<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Include PHPMailer classes manually
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
// require '../../vendor/autoload.php';
include '../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Validate email address format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email address format']);
            exit;
        }

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

        // Generate a unique verification code (6-digit code)
        $verificationCode = mt_rand(100000, 999999);

        // Store the verification code in the database along with the email and timestamp
        $sql_insert_verification = "INSERT INTO verification_codes (email, code, created_at) VALUES (?, ?, NOW())";
        $stmt_insert_verification = $conn->prepare($sql_insert_verification);
        $stmt_insert_verification->bind_param("si", $email, $verificationCode);
        $stmt_insert_verification->execute();

        // Close statement
        $stmt_insert_verification->close();

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'marketing.projectsunlimited@gmail.com'; // Your Gmail address
        $mail->Password = 'vouargdiqfzxgite'; // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set sender email and name
        $mail->setFrom('marketing.projectsunlimited@gmail.com', 'Do-Not-Reply - P.U.');
        $mail->addAddress($email);

        // Style the email body with inline CSS
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Verification Code - Projects Unlimited';
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
            <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
                <h2 style="color: #333;">Password Reset Verification Code</h2>
                <p style="font-size: 16px; color: #555;">
                    We received a request to reset your password. Please use the following verification code to reset your password:
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
            $_SESSION['email'] = $email;
            echo json_encode(['success' => true, 'message' => 'Verification code generated and email sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error sending verification email: ' . $mail->ErrorInfo]);
        }
    } elseif (isset($_POST['verificationCode'])) {
        $verificationCode = $_POST['verificationCode'];
        $email = $_SESSION['email'];

        // Validate verification code
        $sql_check_code = "SELECT created_at FROM verification_codes WHERE email = ? AND code = ? AND status = 'unused' ORDER BY created_at DESC LIMIT 1";
        $stmt_check_code = $conn->prepare($sql_check_code);
        $stmt_check_code->bind_param("si", $email, $verificationCode);
        $stmt_check_code->execute();
        $result_check_code = $stmt_check_code->get_result();

        if ($result_check_code->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid verification code']);
            exit;
        }

        $row_check_code = $result_check_code->fetch_assoc();
        $createdAt = new DateTime($row_check_code['created_at']);
        $currentTime = new DateTime();
        $interval = $currentTime->getTimestamp() - $createdAt->getTimestamp(); // Calculate interval in seconds

        if ($interval > 900) { // 900 seconds = 15 minutes
            // Update verification code status to expired
            $sql_update_status_expired = "UPDATE verification_codes SET status = 'expired' WHERE email = ? AND code = ?";
            $stmt_update_status_expired = $conn->prepare($sql_update_status_expired);
            $stmt_update_status_expired->bind_param("si", $email, $verificationCode);
            $stmt_update_status_expired->execute();
        
            echo json_encode(['success' => false, 'message' => 'Verification code expired']);
            exit;
        }        

        // Mark verification code as used
        $sql_update_status = "UPDATE verification_codes SET status = 'used', entered_code = ? WHERE email = ? AND code = ?";
        $stmt_update_status = $conn->prepare($sql_update_status);
        $stmt_update_status->bind_param("isi", $verificationCode, $email, $verificationCode);
        $stmt_update_status->execute();

        // Verification code is valid
        echo json_encode(['success' => true, 'message' => 'Verification code valid']);
    } elseif (isset($_POST['newPassword'], $_POST['confirmPassword'])) {
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $email = $_SESSION['email'];

        if ($newPassword !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            exit;
        }

        // Update password in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql_update_password = "UPDATE users SET password_hash = ? WHERE email = ?";
        $stmt_update_password = $conn->prepare($sql_update_password);
        $stmt_update_password->bind_param("ss", $hashedPassword, $email);
        $stmt_update_password->execute();

        // Update verification code status to expired for any remaining unused codes
        $sql_update_status_expired = "UPDATE verification_codes SET status = 'expired' WHERE email = ? AND status = 'unused'";
        $stmt_update_status_expired = $conn->prepare($sql_update_status_expired);
        $stmt_update_status_expired->bind_param("s", $email);
        $stmt_update_status_expired->execute();

        echo json_encode(['success' => true, 'message' => 'Password reset successfully']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
