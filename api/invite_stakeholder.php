<?php
// This script now includes its own strong password generator.

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../api/config.php';
require_once __DIR__ . '/db_connect.php';

// --- START: Our new, self-contained password generator function ---
/**
 * Generates a strong, random password that is guaranteed to meet complexity requirements.
 *
 * @param int $length The desired length of the password.
 * @return string The generated strong password.
 */
function generateStrongPassword($length = 12) {
    // Define the character sets we'll use.
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $symbols = '!@#$%^&*()_+-=[]{}|';

    // Start with one character from each required set.
    $password = '';
    $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
    $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
    $password .= $numbers[random_int(0, strlen($numbers) - 1)];
    $password .= $symbols[random_int(0, strlen($symbols) - 1)];

    // Create a pool of all possible characters for the rest.
    $allChars = $lowercase . $uppercase . $numbers . $symbols;

    // Fill the rest of the password with random characters from the pool.
    for ($i = 4; $i < $length; $i++) {
        $password .= $allChars[random_int(0, strlen($allChars) - 1)];
    }

    // Shuffle the result to ensure randomness.
    return str_shuffle($password);
}
// --- END: Password generator function ---


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

        $stmt_check_link = $conn->prepare("SELECT id FROM stakeholder_relationships WHERE stakeholder_id = ? AND student_id = ?");
        $stmt_check_link->bind_param("ii", $stakeholderId, $studentId);
        $stmt_check_link->execute();
        
        if ($stmt_check_link->get_result()->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'This stakeholder is already linked to your account.']);
            exit;
        }

        $stmt_link = $conn->prepare("INSERT INTO stakeholder_relationships (stakeholder_id, student_id) VALUES (?, ?)");
        $stmt_link->bind_param("ii", $stakeholderId, $studentId);
        $stmt_link->execute();
        
        echo json_encode(['success' => true, 'message' => 'Successfully linked to existing stakeholder account!']);

    } else {
        // --- LOGIC FOR A NEW STAKEHOLDER ---
        $usernameParts = explode('@', $stakeholderEmail);
        $stakeholderUsername = $usernameParts[0] . rand(10, 99);
        $tempPassword = generateStrongPassword(); // This now calls our new function.
        $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

        $stmt_insert = $conn->prepare("INSERT INTO users (full_name, username, email, password, role, force_password_change) VALUES (?, ?, ?, ?, 'stakeholder', 1)");
        $stmt_insert->bind_param("ssss", $stakeholderName, $stakeholderUsername, $stakeholderEmail, $hashedPassword);
        
        if ($stmt_insert->execute()) {
            $newStakeholderId = $conn->insert_id;

            $stmt_link = $conn->prepare("INSERT INTO stakeholder_relationships (stakeholder_id, student_id) VALUES (?, ?)");
            $stmt_link->bind_param("ii", $newStakeholderId, $studentId);
            $stmt_link->execute();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USER'];
                $mail->Password   = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = (int)$_ENV['SMTP_PORT'];

                $mail->setFrom('no-reply@spt.com', 'SPT System');
                $mail->addAddress($stakeholderEmail, $stakeholderName);

                $loginLink = "http://localhost:8080/student_performance_tracker/index.html";

                $mail->isHTML(true);
                $mail->Subject = "You have been invited to Student Performance Tracker";
                $mail->Body    = "Hello {$stakeholderName},<br><br>
                                  You have been invited by {$studentFullName} to track their academic progress... (Your credentials are below)...<br>
                                  <b>Username:</b> {$stakeholderUsername}<br>
                                  <b>Temporary Password:</b> {$tempPassword}<br><br>
                                  Please log in at <a href='{$loginLink}'>our login page</a>.";

                $mail->send();
                echo json_encode(['success' => true, 'message' => 'Invitation sent successfully!']);

            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => "User account was created, but the invitation email could not be sent."]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create stakeholder account.']);
        }
    }

    if (isset($stmt)) $stmt->close();
    if (isset($stmt_check_link)) $stmt_check_link->close();
    if (isset($stmt_insert)) $stmt_insert->close();
    if (isset($stmt_link)) $stmt_link->close();
    $conn->close();
}
?>