<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPT - Unit Registration</title>
  <link rel="stylesheet" href="assests/css/styles.css" />
  <link rel="stylesheet" href="assests/css/unit_registration.css" />
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
      <a href="student_dashboard.php" class="sidebar-item">🏠 Dashboard</a>
      <a href="goals.php" class="sidebar-item">🎯 Goal Setting</a>
      <a href="feedback.php" class="sidebar-item">💬 Feedback</a>
      <a href="peer_accountability.php" class="sidebar-item">👫 Peer Accountability</a>
      <a href="unit_registration.php" class="sidebar-item active">📘 Unit Registration</a>
      <a href="api/logout.php" class="sidebar-item logout-btn">Logout</a>
    </nav>

    <div class="sidebar-footer">
        <div class="footer-profile">
            <img src="assests/media/student_icon.png" alt="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" />
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
          <img src="assests/media/student_icon.png" alt="Profile" />
        </div>
      </div>
    </div>

    <!-- Welcome -->
    <section class="welcome-section">
      <h1>Unit & Course Registration</h1>
      <p>Browse available units, manage your schedule, and enroll for the upcoming semester.</p>
    </section>

    <!-- Registration Grid -->
    <div class="registration-grid">
      <!-- Left Column: Course Browser -->
      <div class="left-column">
        <div class="section-card">
          <div class="browser-header">
            <input type="search" class="unit-search" placeholder="Search by unit name or code..." />
            <div class="filter-controls">
              <select class="filter-select">
                <option value="">All Departments</option>
                <option value="cs">Computer Science</option>
                <option value="math">Mathematics</option>
                <option value="history">History</option>
                <option value="writing">Writing</option>
              </select>
            </div>
          </div>

          <div class="unit-list">
            <!-- Unit Card Example 1 -->
            <div class="unit-card">
              <div class="unit-header">
                <h4>Data Structures & Algorithms</h4>
                <span class="unit-code">CS201</span>
              </div>
              <div class="unit-meta">
                <span>👨‍🏫 Dr. Alan Turing</span>
                <span>🗓️ Mon, Wed, Fri 10:00 AM</span>
                <span>📍 Main Hall 301</span>
              </div>
              <p class="unit-description">An in-depth study of data structures, including lists, trees, graphs, and their associated algorithms.</p>
              <div class="unit-footer">
                <button class="enroll-btn">Enroll</button>
              </div>
            </div>

            <!-- Unit Card Example 2 -->
            <div class="unit-card">
              <div class="unit-header">
                <h4>Linear Algebra</h4>
                <span class="unit-code">MATH250</span>
              </div>
              <div class="unit-meta">
                <span>👨‍🏫 Prof. Ada Lovelace</span>
                <span>🗓️ Tue, Thu 1:00 PM</span>
                <span>📍 Science Wing 150</span>
              </div>
              <p class="unit-description">Covers matrices, vector spaces, linear transformations, eigenvalues, and eigenvectors.</p>
              <div class="unit-footer">
                <button class="enroll-btn disabled" disabled>Enrolled</button>
              </div>
            </div>
            
            <!-- Unit Card Example 3 -->
            <div class="unit-card">
              <div class="unit-header">
                <h4>World History: 1500-Present</h4>
                <span class="unit-code">HIST110</span>
              </div>
              <div class="unit-meta">
                <span>👨‍🏫 Dr. Indiana Jones</span>
                <span>🗓️ Tue, Thu 11:00 AM</span>
                <span>📍 Arts Building 210</span>
              </div>
              <p class="unit-description">A survey of major global events, trends, and civilizations from the early modern period to today.</p>
              <div class="unit-footer">
                <button class="enroll-btn full">Full</button>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- Right Column: Registration Details -->
<div class="right-column">
  <!-- My Registered Units -->
  <div class="section-card">
    <div class="registered-header">
      <h2 class="section-title">My Registered Units</h2>
      <button id="editUnitsBtn" class="edit-units-btn">Edit</button>
    </div>
    <div id="registeredList" class="registered-list">
      <!-- 8 Dummy Units -->
      <div class="registered-item">
        <div class="item-details">
          <h4>Linear Algebra</h4>
          <span>MATH250</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>Introduction to Computer Science</h4>
          <span>CS101</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>Academic Writing Skills</h4>
          <span>WRIT100</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>Principles of Microeconomics</h4>
          <span>ECON101</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>General Psychology</h4>
          <span>PSYC100</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>Modern Art History</h4>
          <span>ARTH220</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>Introduction to Sociology</h4>
          <span>SOCI101</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
      <div class="registered-item">
        <div class="item-details">
          <h4>Public Speaking</h4>
          <span>COMM150</span>
        </div>
        <button class="remove-unit-icon">×</button>
      </div>
    </div>
  </div>
</div>