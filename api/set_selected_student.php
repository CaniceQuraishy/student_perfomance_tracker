<?php
// This script sets the chosen student in the session and redirects.

require_once 'auth_check.php'; // Ensures a user is logged in.

// Get the student ID from the URL.
$selectedStudentId = $_GET['student_id'] ?? 0;

if ($selectedStudentId > 0) {
    // TODO: Add a security check here.
    // We should verify that the logged-in stakeholder is actually allowed to view this student.
    // For now, we'll trust the link.

    // Store the selected student's ID in the session.
    $_SESSION['selected_student_id'] = $selectedStudentId;

    // Now, redirect to the student dashboard.
    header("Location: ../student_dashboard.php");
    exit;
} else {
    // If no valid ID was provided, send them back to the selection page.
    header("Location: ../select_student.php");
    exit;
}
?>