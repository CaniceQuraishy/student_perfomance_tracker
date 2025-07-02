<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPT - Student Dashboard</title>
  <link rel="stylesheet" href="assests/css/styles.css" />
  <link rel="stylesheet" href="assests/css/student_dashboard.css" />
  <link rel="icon" type="image/png" href="assests/media/logo.png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="assests/media/logo.png" alt="SPT Logo" class="sidebar-logo" />
      <h2>SPT - Student Performance Tracker</h2>
    </div>

    <nav class="sidebar-menu">
      <a href="student_dashboard.php" class="sidebar-item active">🏠 Dashboard</a>
      <a href="goals.php" class="sidebar-item">🎯 Goal Setting</a>
      <a href="feedback.php" class="sidebar-item">💬 Feedback</a>
      <a href="peer_accountability.php" class="sidebar-item">👫 Peer Accountability</a>
      <a href="unit_registration.php" class="sidebar-item">📘 Unit Registration</a>
      <a href="api/logout.php" class="sidebar-item logout-btn">Logout</a>
    </nav>

    <div class="sidebar-footer">
        <div class="footer-profile">
            <img src="assests/media/student-profile.jpg" alt="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" />
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
        <button class="icon-button">
          <img src="assests/media/bell.png" alt="Notifications" />
        </button>
        <button class="icon-button">
          <img src="assests/media/settings.png" alt="Settings" />
        </button>
        <div class="profile-pic">
          <img src="assests/media/student-profile.jpg" alt="Profile" />
        </div>
      </div>
    </div>

    <!-- Welcome -->
    <section class="welcome-section">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
        <p>Your central hub for academic success. Track goals, register units, and stay informed.</p>
    </section>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
      <!-- Left Column -->
      <div class="left-column">

        <!-- Unit Registration -->
        <div class="section-card">
          <h2 class="section-title">Unit Registration</h2>
          <p class="section-subtitle">Explore available courses and set your goals for the semester.</p>
          
          <div class="course-grid">
            <div class="course-card">
              <div class="course-image"></div>
              <div class="course-content">
                <h3 class="course-title">Introduction to Computer Science</h3>
                <p class="course-meta">Dr. John Doe</p>
                <p class="course-description">An overview of computing concepts, programming fundamentals, and more.</p>
                <button class="course-button">Enroll Now</button>
              </div>
              <a href="unit_registration.html">Explore Registered Units</a>
            </div>

            <div class="course-card">
              <div class="course-image course-calc"></div>
              <div class="course-content">
                <h3 class="course-title">Calculus I</h3>
                <p class="course-meta">Prof. Sarah Lee</p>
                <p class="course-description">Differential and integral calculus with real-world applications.</p>
                <button class="course-button">Enroll Now</button>
              </div>
            </div>

            <div class="course-card">
              <div class="course-image course-writing"></div>
              <div class="course-content">
                <h3 class="course-title">Academic Writing Skills</h3>
                <p class="course-meta">Ms. Jane Doe</p>
                <p class="course-description">Critical thinking, research, and professional writing development.</p>
                <button class="course-button">Enroll Now</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Goals -->
        <div class="section-card">
          <h2 class="section-title">Current Goals</h2>
          <p class="section-subtitle">Monitor performance and track progress.</p>
          <a href="goals.html" class="add-goal-btn">+ Add Goal</a>
          <table class="goals-table">
            <thead>
              <tr>
                <th>Assessment (Coursework)</th>
                <th>Target Score</th>
                <th>Actual Score</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Midterm Exam - CS101</td>
                <td>90%</td>
                <td>
                  <div class="progress-wrapper">
                    <div class="progress-bar"><div class="progress-fill progress-90"></div></div>
                    <span>90%</span>
                  </div>
                </td>
                <td><span class="status-badge status-met">Met</span></td>
              </tr>
              <tr>
                <td>Final Project - MKT200</td>
                <td>90%</td>
                <td>
                  <div class="progress-wrapper">
                    <div class="progress-bar"><div class="progress-fill progress-70"></div></div>
                    <span>70%</span>
                  </div>
                </td>
                <td><span class="status-badge status-ongoing">Pending</span></td>
              </tr>
              <tr>
                <td>Quiz 2 - JAV105</td>
                <td>70%</td>
                <td>
                  <div class="progress-wrapper">
                    <div class="progress-bar"><div class="progress-fill progress-66"></div></div>
                    <span>66.66%</span>
                  </div>
                </td>
                <td><span class="status-badge status-failed">Failed</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Right Column -->
      <div class="right-column">
        <!-- Peers -->
        <div class="section-card peer-accountability">
          <h2 class="section-title">Peer Accountability</h2>
          <p class="section-subtitle">Connect with friends to stay motivated.</p>
          <input type="text" id="search-peer" class="search-peer-input" placeholder="Search peer by name" />
          <a href="peer_accountability.html" class="add-goal-btn">+ Add Friend</a>
          
          <div class="peer">
            <div class="avatar-circle">A</div>
            <div>
              <strong>Alice Wonderland</strong><br />
              <small>✅ 4 Met • ⏳ 2 Pending • ❌ 1 Failed</small>
            </div>
          </div>

          <div class="peer">
            <div class="avatar-circle">B</div>
            <div>
              <strong>Bob The Builder</strong><br />
              <small>✅ 3 Met • ⏳ 2 Pending • ❌ 2 Failed</small>
            </div>
          </div>

          <div class="peer">
            <div class="avatar-circle">C</div>
            <div>
              <strong>Charlie Chaplin</strong><br />
              <small>✅ 2 Met • ⏳ 2 Pending • ❌ 3 Failed</small>
            </div>
          </div>
        </div>

        <!-- Stakeholder Invites -->
        <div class="section-card invites-section">
          <h2 class="section-title">Stakeholder Invites</h2>
          <p class="section-subtitle">Invite your parent/guardian or mentor to track your academic progress.</p>
          <form class="invite-form">
            <label>Stakeholder’s Name</label>
            <input type="text" class="invite-input" placeholder="Enter Stakeholder’s Full Name" />
            <label>Email</label>
            <input type="email" class="invite-input" placeholder="Enter their email address" />
            <button class="send-invite-btn">Send Invite</button>
          </form>
        </div>
      </div>
    </div>
  </main>

</body>
</html>
