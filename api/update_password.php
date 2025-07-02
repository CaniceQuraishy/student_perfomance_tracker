<?php
// This script handles the final password update.

require_once 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    // --- 1. Validation ---
    if (empty($token) || empty($password) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }
    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long.']);
        exit;
    }

    // --- 2. Find the user by the reset token ---
    
    // Let's make sure the token we are searching for is a valid hexadecimal string.
    // This is a good security and data-integrity check.
    if (!ctype_xdigit($token)) {
        echo json_encode(['success' => false, 'message' => 'The provided token is malformed.']);
        exit;
    }
    
    // We also check that the token has not expired.
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Token is valid and has not expired.
        $user = $result->fetch_assoc();
        $userId = $user['id'];

        // --- 3. Hash the new password ---
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // --- 4. Update the user's password in the database ---
        $stmt_update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?");
        $stmt_update->bind_param("si", $hashedPassword, $userId);
        
        if ($stmt_update->execute()) {
            echo json_encode(['success' => true, 'message' => 'Your password has been updated successfully! You can now log in.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'An error occurred while updating your password.']);
        }

    } else {
        // The token was not found or has expired.
        // For debugging, let's see how many rows were found.
        // echo json_encode(['success' => false, 'message' => 'DEBUG: Found ' . $result->num_rows . ' matching tokens.']);
        echo json_encode(['success' => false, 'message' => 'This reset link is invalid or has expired. Please request a new one.']);
    }
    
    $stmt->close();
    $conn->close();
}