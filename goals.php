<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Goal Setting - SPT</title>
  <link rel="stylesheet" href="assests/css/styles.css" />
  <link rel="stylesheet" href="assests/css/goals.css" />

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
      <a href="goals.php" class="sidebar-item active">🎯 Goal Setting</a>
      <a href="feedback.php" class="sidebar-item">💬 Feedback</a>
      <a href="peer_accountability.php" class="sidebar-item">👫 Peer Accountability</a>
      <a href="unit_registration.php " class="sidebar-item">📘 Unit Registration</a>
      <a href="api/logout.php" class="sidebar-item logout-btn">Logout</a>
    </nav>

    <div class="sidebar-footer">
      <div class="footer-profile">
        <img src="assests/media/student-profile.jpg" alt="Jane Doe" />
        <div class="footer-details">
          <strong>Jane Doe</strong><br />
          <span>Student</span>
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

    <!-- Welcome Section -->
    <section class="welcome-section">
      <h1>🎯 Goal Setting</h1>
      <p>Create and manage your academic goals easily.</p>
    </section>

    <!-- Goal Grid Layout -->
    <div class="goal-grid">
      <!-- Goal Form -->
      <div class="section-card">
        <h2 class="section-title">Set a New Academic Goal</h2>
        <p class="section-subtitle">Define your targets for assessments this semester.</p>
        <form class="goal-form">
          <select required>
            <option value="" disabled selected>Select Unit</option>
            <option value="CS101">CS101 - Computer Science</option>
            <option value="MKT200">MKT200 - Marketing</option>
            <option value="JAV105">JAV105 - Java Basics</option>
          </select>

          <select required>
            <option value="" disabled selected>Select Assessment</option>
            <option value="midterm">CAT 1</option>
            <option value="final">LAB 1</option>
            <option value="quiz">CAT 2</option>
          </select>

          <input type="number" placeholder="Input Target Score" required />
          <button type="submit">Add Goal</button>
        </form>
      </div>

      <!-- Goal Table -->
      <div class="section-card">
        <h2 class="section-title">Your Goals</h2>
        <p class="section-subtitle">Overview of your academic targets and progress.</p>
        <div class="table-container">
          <table class="goal-table">
            <thead>
              <tr>
                <th>Unit</th>
                <th>Assessment</th>
                <th>Target</th>
                <th>Marks</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Midterm - CS101</td>
                <td>CAT 1</td>
                <td>25/30</td>
                <td>26/30</td>
                <td>2025-07-05</td>
                <td><span class="status-badge status-met">Met</span></td>
                <td>
                  <button class="edit-btn" title="Edit Goal">✏️</button>
                  <button class="delete-btn" title="Delete Goal">🗑️</button>
                </td>
              </tr>
              <tr>
                <td>Marketing - MKT200</td>
                <td>CAT 2</td>
                <td>22/25</td>
                <td>-</td>
                <td>2025-08-15</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td>
                  <button class="edit-btn" title="Edit Goal">✏️</button>
                  <button class="delete-btn" title="Delete Goal">🗑️</button>
                </td>
              </tr>
              <tr>
                <td>Java Basics - JAV105</td>
                <td>LAB 1</td>
                <td>18/20</td>
                <td>15/20</td>
                <td>2025-07-20</td>
                <td><span class="status-badge status-not-met">Not Met</span></td>
                <td>
                  <button class="edit-btn" title="Edit Goal">✏️</button>
                  <button class="delete-btn" title="Delete Goal">🗑️</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>

</body>
</html>
