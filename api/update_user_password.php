<?php
// This script handles updating the user's password after a forced change.

// We need to access the session to know which user to update.
session_start();

// We need our database connection.
require_once 'db_connect.php';

// We'll send back a JSON response.
header('Content-Type: application/json');

// --- 1. Security Check ---
// Make sure a user is actually logged in.
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Authentication error. Please log in again.']);
    exit;
}

// Only process POST requests.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    // --- 2. Server-Side Validation ---
    if (empty($password) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in both password fields.']);
        exit;
    }
    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'The new passwords do not match.']);
        exit;
    }

    // Enforce our strong password rules.
    $passwordError = '';
    if (strlen($password) < 8) {
        $passwordError = 'Password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $passwordError = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[a-z]/', $password)) {
        $passwordError = 'Password must contain at least one lowercase letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $passwordError = 'Password must contain at least one number.';
    } elseif (!preg_match('/[!@#$%^&*()_+\-=\[\]{}|]/', $password)) {
        $passwordError = 'Password must contain at least one special character.';
    }

    if (!empty($passwordError)) {
        echo json_encode(['success' => false, 'message' => $passwordError]);
        exit;
    }

    // --- 3. Hash the New Password ---
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // --- 4. Update the Database ---
    // This query updates the password and sets the 'force_password_change' flag back to 0.
    $stmt = $conn->prepare("UPDATE users SET password = ?, force_password_change = 0 WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);

    if ($stmt->execute()) {
        // The update was successful.
        echo json_encode([
            'success' => true, 
            'message' => 'Password updated successfully!',
            'role' => $_SESSION['role'] // Send the user's role back to JS for redirection.
        ]);
    } else {
        // Handle a potential database update error.
        echo json_encode(['success' => false, 'message' => 'An error occurred while updating your password.']);
    }

    $stmt->close();
    $conn->close();
}
?>