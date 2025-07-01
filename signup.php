<?php
// This script now handles the new 'username' field.

// We still need our database connection.
require_once 'db_connect.php'; 

// Set the response header to JSON.
header('Content-Type: application/json');

// We only want to process POST requests.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- 1. Get and Sanitize Data, including the new username ---
    $fullName = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? ''); // Get the new username
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'student';

    // --- 2. Server-Side Validation ---
    if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long.']);
        exit;
    }
    
    // --- 3. Check for Duplicate Username OR Email ---
    // We'll check both at the same time for efficiency.
    // A user shouldn't be able to sign up if either the username or email is already taken.
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Since we don't know which one was the duplicate, we give a generic message.
        // A more advanced system might check them separately to give a more specific error.
        echo json_encode([
            'success' => false,
            'message' => 'This username or email address is already registered.'
        ]);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // --- 4. Hash the Password ---
    // This part is unchanged and still critical for security.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // --- 5. Insert the New User into the Database ---
    // We update the SQL query to include the new 'username' column.
    $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
    // The number of "s" characters must match the number of question marks.
    $stmt->bind_param("sssss", $fullName, $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        // Success!
        echo json_encode([
            'success' => true,
            'message' => "Account for {$fullName} created successfully!"
        ]);
    } else {
        // Handle a potential database insertion error.
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred while creating your account. Please try again.'
        ]);
    }

    // --- 6. Clean Up ---
    $stmt->close();
    $conn->close();

} else {
    // Handle cases where the file is accessed directly.
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>