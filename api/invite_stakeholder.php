<?php
// This script handles both new and existing stakeholders for invitations.

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader and our database connection.
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../api/config.php'; // Correct path to load .env variables
require_once __DIR__ . '/db_connect.php';

// Set the response header to JSON.
header('Content-Type: application/json');

// A student must be logged in to send an invite.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo json_encode(['success' => false, 'message' => 'Authentication required to send invites.']);
    exit;
}

// Only process POST requests.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['user_id'];
    $studentFullName = $_SESSION['full_name'];
    $stakeholderName = trim($_POST['stakeholder_name'] ?? '');
    $stakeholderEmail = trim($_POST['stakeholder_email'] ?? '');

    // Basic validation.
    if (empty($stakeholderName) || empty($stakeholderEmail) || !filter_var($stakeholderEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please provide a valid name and email address.']);
        exit;
    }

    // Check if a user with this email already exists.
    $stmt = $conn->prepare("SELECT id, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $stakeholderEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // --- LOGIC FOR AN EXISTING STAKEHOLDER ---
        $existingUser = $result->fetch_assoc();
        $stakeholderId = $existingUser['id'];

        if ($existingUser['role'] !== 'stakeholder') {
            echo json_encode(['success' => false, 'message' => 'A user with this email exists but is not a stakeholder.']);
            exit;
        }

        // Check if this student is already linked to this stakeholder.
        $stmt_check_link = $conn->prepare("SELECT id FROM stakeholder_relationships WHERE stakeholder_id = ? AND student_id = ?");
        $stmt_check_link->bind_param("ii", $stakeholderId, $studentId);
        $stmt_check_link->execute();
        
        if ($stmt_check_link->get_result()->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'This stakeholder is already linked to your account.']);
            exit;
        }

        // If not linked, create the new relationship.
        $stmt_link = $conn->prepare("INSERT INTO stakeholder_relationships (stakeholder_id, student_id) VALUES (?, ?)");
        $stmt_link->bind_param("ii", $stakeholderId, $studentId);
        $stmt_link->execute();
        
        // TODO: We can later send a different, simpler email for this case.
        echo json_encode(['success' => true, 'message' => 'Successfully linked to the existing stakeholder account!']);

    } else {
        // --- LOGIC FOR A NEW STAKEHOLDER ---
        // Generate all the new credentials.
        $usernameParts = explode('@', $stakeholderEmail);
        $stakeholderUsername = $usernameParts[0] . rand(10, 99);
        $tempPassword = bin2hex(random_bytes(4));
        $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

        // Insert the new stakeholder into the users table.
        $stmt_insert = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, 'stakeholder')");
        $stmt_insert->bind_param("ssss", $stakeholderName, $stakeholderUsername, $stakeholderEmail, $hashedPassword);
        
        if ($stmt_insert->execute()) {
            $newStakeholderId = $conn->insert_id;

            // Link the new stakeholder to the inviting student.
            $stmt_link = $conn->prepare("INSERT INTO stakeholder_relationships (stakeholder_id, student_id) VALUES (?, ?)");
            $stmt_link->bind_param("ii", $newStakeholderId, $studentId);
            $stmt_link->execute();

            // --- Send the Welcome Email ---
            $mail = new PHPMailer(true);
            try {
                // Server settings from our .env file.
                $mail->isSMTP();
                $mail->Host       = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USER'];
                $mail->Password   = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = (int)$_ENV['SMTP_PORT'];

                // Recipients
                $mail->setFrom('no-reply@spt.com', 'SPT System');
                $mail->addAddress($stakeholderEmail, $stakeholderName);

                // Define the login link for the email body.
                $loginLink = "http://localhost:8080/student_performance_tracker/index.html";

                // The email content, using double quotes to process variables.
                $mail->isHTML(true);
                $mail->Subject = "You have been invited to Student Performance Tracker";
                $mail->Body    = "Hello {$stakeholderName},<br><br>
                                  You have been invited by {$studentFullName} to track their academic progress on the Student Performance Tracker.<br><br>
                                  You can log in using the following credentials:<br>
                                  <b>Username:</b> {$stakeholderUsername}<br>
                                  <b>Temporary Password:</b> {$tempPassword}<br><br>
                                  Please log in at <a href='{$loginLink}'>our login page</a> and change your password as soon as possible.<br><br>
                                  Thank you!";

                $mail->send();
                echo json_encode(['success' => true, 'message' => 'Invitation sent successfully!']);

            } catch (Exception $e) {
                // This catches errors specifically from the email sending process.
                echo json_encode(['success' => false, 'message' => "User account was created, but the invitation email could not be sent."]);
            }
        } else {
            // This catches errors if the database insertion fails.
            echo json_encode(['success' => false, 'message' => 'Failed to create stakeholder account.']);
        }
    }

    // Always close the statement and connection.
    if (isset($stmt)) $stmt->close();
    if (isset($stmt_check_link)) $stmt_check_link->close();
    if (isset($stmt_insert)) $stmt_insert->close();
    if (isset($stmt_link)) $stmt_link->close();
    $conn->close();
} 
?>