<?php
// This script checks if a user is logged in.
// We will include it at the top of every protected page.

// A session must be started before we can access session variables.
session_start();

// Check if the user_id session variable is set.
// If it's not set, it means the user is not logged in.
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect them to the login page (index.html).
    header("Location: index.html");
    exit; // Stop the script from running further.
}

// Optional: We can also check if the user has the correct role for the page.
// For example, on the student dashboard, we only want 'student' roles.
// We can add this logic later as we build the other dashboards.
/*
if ($_SESSION['role'] !== 'student') {
    // If the role is not 'student', send them away.
    // We could send them to a generic 'access-denied.html' page.
    header("Location: access-denied.html");
    exit;
}
*/

?>