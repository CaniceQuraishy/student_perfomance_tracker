<?php
// We start by checking if the user is logged in.
require_once 'api/auth_check.php';

// This page is only for stakeholders.
if ($_SESSION['role'] !== 'stakeholder') {
    // If a non-stakeholder somehow lands here, send them away.
    header("Location: index.html");
    exit;
}

// We need a database connection to find the students.
require_once 'api/db_connect.php';

// Get the logged-in stakeholder's ID from the session.
$stakeholderId = $_SESSION['user_id'];
$students = []; // An empty array to hold the student data.

// Find all student_id's linked to this stakeholder.
$stmt = $conn->prepare(
    "SELECT u.id, u.full_name, u.username FROM users u " .
    "JOIN stakeholder_relationships sr ON u.id = sr.student_id " .
    "WHERE sr.stakeholder_id = ?"
);
$stmt->bind_param("i", $stakeholderId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $students[] = $row; // Add each student to our array.
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Select Student - SPT</title>
    <!-- We can reuse our login/signup page styles for this simple page. -->
    <link rel="stylesheet" href="assests/css/signup.css" />
    <link rel="icon" type="image/png" href="assests/media/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        /* A few extra styles just for this page. */
        .student-selection-card {
            text-align: left;
        }
        .student-list-item {
            display: block;
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .student-list-item:hover {
            border-color: #4A5A9C;
            background-color: #eef2ff;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <a href="api/logout.php" class="top-right-link">Logout</a>
        <div class="login-card student-selection-card">
            <h1 class="title">Select a Student</h1>
            <p class="subtitle">Please choose which student's dashboard you would like to view.</p>
            
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <!-- Each student is a link that will trigger our selection logic. -->
                    <a href="api/set_selected_student.php?student_id=<?php echo $student['id']; ?>" class="student-list-item">
                        <?php echo htmlspecialchars($student['full_name']); ?>
                        <br>
                        <small>(ID: <?php echo htmlspecialchars($student['username']); ?>)</small>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You are not currently linked to any students.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>