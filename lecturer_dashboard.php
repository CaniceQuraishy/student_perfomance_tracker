<?php
// We start by checking if the user is logged in.
require_once 'api/auth_check.php';

// We can also add a role-specific check.
// If the logged-in user's role is not 'lecturer', we can redirect them.
if ($_SESSION['role'] !== 'lecturer') {
    // For now, let's just send them back to the student dashboard.
    // In a real app, you might have a dedicated 'access-denied.html' page.
    header("Location: student_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lecturer Dashboard - SPT</title>
    <!-- We can reuse our existing master stylesheet. -->
    <link rel="stylesheet" href="assests/css/styles.css" />
    <link rel="icon" type="image/png" href="assests/media/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="assests/media/logo.png" alt="SPT Logo" class="sidebar-logo" />
            <h2>SPT - Lecturer Portal</h2>
        </div>

        <!-- This is a simplified sidebar for the lecturer view. -->
        <nav class="sidebar-menu">
            <a href="lecturer_dashboard.php" class="sidebar-item active">🏠 Dashboard</a>
            <a href="#" class="sidebar-item">📊 My Assessments</a>
            <a href="#" class="sidebar-item">💬 View Feedback</a>
            <a href="api/logout.php" class="sidebar-item logout-btn">Logout</a>
        </nav>

        <div class="sidebar-footer">
            <div class="footer-profile">
                <img src="assests/media/lecturer-profile.jpg" alt="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" />
                <div class="footer-details">
                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                    <br>
                    <span><?php echo htmlspecialchars(ucfirst($_SESSION['role'])); ?></span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Action Bar -->
        <div class="top-bar">
            <div class="spacer"></div>
            <div class="top-icons">
                <button class="icon-button"><img src="assests/media/bell.png" alt="Notifications" /></button>
                <button class="icon-button"><img src="assests/media/settings.png" alt="Settings" /></button>
                <div class="profile-pic"><img src="assests/media/lecturer-profile.jpg" alt="Profile" /></div>
            </div>
        </div>

        <!-- Welcome Section -->
        <section class="welcome-section">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
            <p>This is your lecturer dashboard. This area is under construction.</p>
        </section>

        <!-- Placeholder for future content -->
        <div class="section-card">
            <h2 class="section-title">Coming Soon</h2>
            <p>Lecturer-specific features like assessment creation and feedback management will be available here.</p>
        </div>
    </main>

</body>
</html>