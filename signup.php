<?php

// Set the content type to application/json so the front-end knows what to expect.
header('Content-Type: application/json');

// We only want to process POST requests.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- 1. Get the data from the form ---
    // We use trim() to remove any accidental whitespace.
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'student'; // Default to 'student' if not provided.

    // --- 2. Server-Side Validation ---
    // IMPORTANT: Always validate on the backend, even if you validate on the frontend.
    // A user can bypass frontend validation.
    
    if (empty($name) || empty($email) || empty($password)) {
        // Send back an error response.
        echo json_encode([
            'success' => false,
            'message' => 'Please fill in all required fields.'
        ]);
        exit; // Stop the script
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Send back an error response for an invalid email.
        echo json_encode([
            'success' => false,
            'message' => 'Please provide a valid email address.'
        ]);
        exit;
    }

    if (strlen($password) < 8) {
        // Send back an error response for a short password.
        echo json_encode([
            'success' => false,
            'message' => 'Password must be at least 8 characters long.'
        ]);
        exit;
    }

    // --- 3. Process the Data (Simulating Database Interaction) ---
    // In a real application, this is where you would:
    //  a. Hash the password: $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //  b. Check if the email already exists in your database.
    //  c. If not, insert the new user record.

    // For now, we'll just simulate this.
    // Let's pretend 'admin@example.com' is already taken.
    if ($email === 'admin@example.com') {
        echo json_encode([
            'success' => false,
            'message' => 'This email address is already registered.'
        ]);
        exit;
    }

    // --- 4. Send a Success Response ---
    // If we get here, it means all validation passed and the "user" was "created".
    echo json_encode([
        'success' => true,
        'message' => "Account for {$name} created successfully!"
    ]);

} else {
    // If someone tries to access this file directly via their browser.
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>