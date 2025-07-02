<?php
// This page allows the user to set a new password.

// First, we need to get the token from the URL.
// The $_GET superglobal is used to get variables from the URL query string.
$token = $_GET['token'] ?? '';

// We should check if the token is empty.
if (empty($token)) {
    die("Invalid reset link. No token provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - SPT</title>
    <link rel="stylesheet" href="assests/css/signup.css" /> 
    <link rel="icon" type="image/png" href="assests/media/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="page-container">
        <div class="login-card">
            <img src="assests/media/logo.png" alt="Logo" class="logo-icon" />
            <h1 class="title">Set a New Password</h1>
            <p class="subtitle">Please enter and confirm your new password below.</p>

            <form id="resetPasswordForm" class="login-form">
                <!-- This is a hidden input to send the token along with the form. -->
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required />
                    <p class="error-message"></p>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm New Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="••••••••" required />
                    <p class="error-message"></p>
                </div>

                <button type="submit" class="login-btn">Update Password</button>
            </form>
            <p id="responseMessage" class="response-message"></p>
        </div>
    </div>
    <!-- We will create this JS file next. -->
    <script src="assests/js/reset_password.js" defer></script>
</body>
</html>