<?php
// This script handles the student's invitation to a stakeholder.

// Start the session to get the logged-in student's ID.
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load our necessary files.
require '../vendor/autoload.php';
require_once 'db_connect.php';

header('Content-Type: application/json');

// Make sure a student is logged in before proceeding.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo json_encode(['success' => false, 'message' => 'Authentication required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['user_id'];
    $stakeholderName = trim($_POST['stakeholder_name'] ?? '');
    $stakeholderEmail = trim($_POST['stakeholder_email'] ?? '');

    // Basic validation.
    if (empty($stakeholderName) || empty($stakeholderEmail) || !filter_var($stakeholderEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please provide a valid name and email address.']);
        exit;
    }

    // --- Check if a user with this email already exists ---
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $stakeholderEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'A user with this email already exists in the system.']);
        exit;
    }

    // --- Generate Credentials for the New Stakeholder ---
    // Let's create a simple username from their email.
    $usernameParts = explode('@', $stakeholderEmail);
    $stakeholderUsername = $usernameParts[0] . rand(10, 99); // e.g., 'john.doe87'
    
    // Generate a secure, random temporary password.
    $tempPassword = bin2hex(random_bytes(4)); // Creates an 8-character password.
    $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

    // --- Create the Stakeholder User Account ---
    $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, 'stakeholder')");
    $stmt->bind_param("ssss", $stakeholderName, $stakeholderUsername, $stakeholderEmail, $hashedPassword);
    
    if ($stmt->execute()) {
        $newStakeholderId = $conn->insert_id; // Get the ID of the user we just created.

        // --- Link the Stakeholder to the Student ---
        $stmt_link = $conn->prepare("INSERT INTO stakeholder_relationships (stakeholder_id, student_id) VALUES (?, ?)");
        $stmt_link->bind_param("ii", $newStakeholderId, $studentId);
        $stmt_link->execute();

        // --- Send the Invitation Email ---
        $mail = new PHPMailer(true);
        try {
            // Your Gmail server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $_ENV['SMTP_PORT'];

            // Recipients
            $mail->setFrom('no-reply@spt.com', 'SPT System');
            $mail->addAddress($stakeholderEmail, $stakeholderName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'You have been invited to Student Performance Tracker';
            $mail->Body    = "Hello {$stakeholderName},<br><br>You have been invited by a student to track their academic progress on the Student Performance Tracker.<br><br>You can log in using the following credentials:<br><b>Username:</b> {$stakeholderUsername}<br><b>Temporary Password:</b> {$tempPassword}<br><br>Please log in at <a href='http://localhost:8080/student_performance_tracker/'>our login page</a> and change your password immediately.<br><br>Thank you!";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Invitation sent successfully!']);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'User created, but the invitation email could not be sent.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create the stakeholder account.']);
    }

    $stmt->close();
    $conn->close();
}