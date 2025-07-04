<?php
// Check that a user is logged in to access this page.
require_once 'api/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change Password - SPT</title>
    <!-- We can reuse our existing signup/login styles. -->
    <link rel="stylesheet" href="assests/css/signup.css" /> 
    <link rel="icon" type="image/png" href="assests/media/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="page-container">
        <a href="api/logout.php" class="top-right-link">Logout</a>
        <div class="login-card">
            <img src="assests/media/logo.png" alt="Logo" class="logo-icon" />
            <h1 class="title">Update Your Password</h1>
            <p class="subtitle">For your security, you must set a new password before you can continue.</p>

            <form id="changePasswordForm" class="login-form">
                <!-- We don't need a hidden token here because the user is already authenticated via their session. -->

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

                <button type="submit" class="login-btn">Set New Password</button>
            </form>
            <p id="responseMessage" class="response-message"></p>
        </div>
    </div>
    <!-- We will create this new JS file next. -->
    <script src="assests/js/change_password.js" defer></script>
</body>
</html>