<?php
// This script handles the user login process.

// We need to start a session here to store login state.
// This must be called before any output is sent to the browser.
session_start();

// Database connection.
require_once 'db_connect.php';

// Set the response header to JSON.
header('Content-Type: application/json');

// We only want to process POST requests.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- 1. Get the data from the form ---
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // --- 2. Basic Validation ---
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please enter both username and password.']);
        exit;
    }

    // --- 3. Find the user in the database ---
    // We use a prepared statement to safely look up the user by their username.
   $stmt = $conn->prepare("SELECT id, username, full_name, password, role, force_password_change FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // We found exactly one user with that username.
        $user = $result->fetch_assoc();

        // --- 4. Verify the password ---
        // Use password_verify() to compare the submitted password with the hashed password from the database.
        // This is the secure way to check passwords.
        if (password_verify($password, $user['password'])) {
            // --- The password is correct! Login successful. ---

            // --- 5. Store user data in the session ---
            // This is how we "log the user in" for subsequent page loads.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // Send a success response back to the JavaScript, including the user's role.
            // The JavaScript will use this role to decide where to redirect the user.
            // This is the new success block that checks our flag
            echo json_encode([
                'success' => true,
                'message' => 'Login successful!',
                'role' => $user['role'],
                // We add a new key to our response. It will be true if the flag is 1, false otherwise.
                'requires_change' => (bool)$user['force_password_change'] 
            ]);

        } else {
            // The username was correct, but the password was not.
            // We give a generic error for security reasons.
            echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        }

    } else {
        // We did not find any user with that username.
        // Again, a generic error is more secure than saying "Username not found".
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    }

    // --- 6. Clean Up ---
    $stmt->close();
    $conn->close();

} else {
    // Handle cases where the file is accessed directly.
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>