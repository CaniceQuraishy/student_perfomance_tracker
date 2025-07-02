<?php
// Final, corrected script for handling password reset requests via username.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // We receive the username from the form.
    $username = trim($_POST['username'] ?? '');

    if (empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Please enter your username.']);
        exit;
    }

    // --- Find the user in the database BY USERNAME and get their email. ---
    $stmt = $conn->prepare("SELECT id, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // We found the user.
        $user = $result->fetch_assoc();
        $userEmail = $user['email'];

        // --- Generate a secure token and set the expiration using the database's clock. ---
        $token = bin2hex(random_bytes(32));

        // Let's store the token in the database for THIS user.
        // The query now correctly uses the username in the WHERE clause.
        $stmt_update = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires_at = NOW() + INTERVAL 1 HOUR WHERE username = ?");
        $stmt_update->bind_param("ss", $token, $username);
        
        // We execute the update query.
        if ($stmt_update->execute()) {
            
            // Now that the token is saved, we can send the email.
            $mail = new PHPMailer(true);
            try {
                // Server settings (make sure to update your credentials here).
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USER'];
                $mail->Password   = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                // Recipients
                $mail->setFrom('no-reply@spt.com', 'SPT System');
                $mail->addAddress($userEmail); // Use the email we found earlier.

                // Email Content
                $resetLink = "http://localhost:8080/student_performance_tracker/reset_password.php?token=" . $token;
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request for SPT';
                $mail->Body    = "Hello,<br><br>You requested a password reset. Please click the link below to set a new password:<br><br><a href='{$resetLink}'>Reset Your Password</a><br><br>This link will expire in one hour.";

                $mail->send();
                echo json_encode(['success' => true, 'message' => 'A password reset link has been sent to the email associated with your account.']);

            } catch (Exception $e) {
                // This catches errors from PHPMailer itself.
                echo json_encode(['success' => false, 'message' => "Message could not be sent. Please contact support."]);
            }

        } else {
            // This would happen if the database UPDATE query failed.
            echo json_encode(['success' => false, 'message' => 'Could not save reset token. Please try again.']);
        }

    } else {
        // If the username doesn't exist, we send back a generic success message for security.
        echo json_encode(['success' => true, 'message' => 'If an account with that username exists, a reset link has been sent to its associated email.']);
    }

    $stmt->close();
    $conn->close();
}