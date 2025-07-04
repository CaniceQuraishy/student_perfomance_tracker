<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPT - Feedback</title>
  <link rel="stylesheet" href="assests/css/styles.css" />
  <link rel="stylesheet" href="assests/css/feedback.css" />
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
      <a href="feedback.php" class="sidebar-item active">💬 Feedback</a>
      <a href="peer_accountability.php" class="sidebar-item">👫 Peer Accountability</a>
      <a href="unit_registration.php" class="sidebar-item">📘 Unit Registration</a>
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
      <h1>Feedback Center</h1>
      <p>View instructor feedback, submit course evaluations, and track your academic progress discussions.</p>
    </section>

    <!-- Feedback Grid -->
    <div class="feedback-grid">
      <!-- Left Column -->
      <div class="left-column">

        <!-- Recent Feedback -->
        <div class="section-card">
          <h2 class="section-title">Recent Feedback</h2>
          <p class="section-subtitle">Latest comments and evaluations from your instructors.</p>
          
          <div class="feedback-list">
            <div class="feedback-item">
              <div class="feedback-header">
                <div class="course-info">
                  <h3 class="course-name">Introduction to Computer Science</h3>
                  <span class="instructor-name">Dr. John Doe</span>
                </div>
                <div class="feedback-meta">
                  <span class="feedback-date">Dec 15, 2024</span>
                  <span class="feedback-grade grade-excellent">A</span>
                </div>
              </div>
              <div class="feedback-content">
                <p class="feedback-text">Excellent work on your midterm project! Your implementation of the sorting algorithms was particularly impressive. Keep up the great work and focus on code documentation for future assignments.</p>
                <div class="feedback-tags">
                  <span class="tag tag-positive">Excellent</span>
                  <span class="tag tag-improvement">Documentation</span>
                </div>
              </div>
            </div>

            <div class="feedback-item">
              <div class="feedback-header">
                <div class="course-info">
                  <h3 class="course-name">Calculus I</h3>
                  <span class="instructor-name">Prof. Sarah Lee</span>
                </div>
                <div class="feedback-meta">
                  <span class="feedback-date">Dec 12, 2024</span>
                  <span class="feedback-grade grade-good">B+</span>
                </div>
              </div>
              <div class="feedback-content">
                <p class="feedback-text">Good understanding of integration concepts. Your problem-solving approach is methodical, but pay attention to calculation errors in complex problems. Practice more chain rule applications.</p>
                <div class="feedback-tags">
                  <span class="tag tag-positive">Good Understanding</span>
                  <span class="tag tag-improvement">Calculation Accuracy</span>
                </div>
              </div>
            </div>

            <div class="feedback-item">
              <div class="feedback-header">
                <div class="course-info">
                  <h3 class="course-name">Academic Writing Skills</h3>
                  <span class="instructor-name">Ms. Jane Doe</span>
                </div>
                <div class="feedback-meta">
                  <span class="feedback-date">Dec 10, 2024</span>
                  <span class="feedback-grade grade-average">C+</span>
                </div>
              </div>
              <div class="feedback-content">
                <p class="feedback-text">Your research paper shows good critical thinking, but the structure needs improvement. Work on creating stronger topic sentences and smoother transitions between paragraphs. Schedule a meeting to discuss revision strategies.</p>
                <div class="feedback-tags">
                  <span class="tag tag-positive">Critical Thinking</span>
                  <span class="tag tag-improvement">Structure</span>
                  <span class="tag tag-neutral">Meeting Required</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Feedback Analytics -->
        <div class="section-card">
          <h2 class="section-title">Feedback Analytics</h2>
          <p class="section-subtitle">Track your performance trends and improvement areas.</p>
          
          <div class="analytics-grid">
            <div class="analytics-card">
              <div class="analytics-icon positive">📈</div>
              <div class="analytics-content">
                <h3>Positive Feedback</h3>
                <span class="analytics-number">87%</span>
                <p class="analytics-trend">+5% from last month</p>
              </div>
            </div>
            
            <div class="analytics-card">
              <div class="analytics-icon improvement">🎯</div>
              <div class="analytics-content">
                <h3>Areas for Improvement</h3>
                <span class="analytics-number">3</span>
                <p class="analytics-trend">Focus areas identified</p>
              </div>
            </div>
            
            <div class="analytics-card">
              <div class="analytics-icon response">💬</div>
              <div class="analytics-content">
                <h3>Response Rate</h3>
                <span class="analytics-number">92%</span>
                <p class="analytics-trend">Course evaluations completed</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="right-column">
        
        <!-- Submit Feedback -->
        <div class="section-card">
          <h2 class="section-title">Course Evaluation</h2>
          <p class="section-subtitle">Share your thoughts about your courses and instructors.</p>
          
          <form class="feedback-form">
            <div class="form-group">
              <label for="course-select">Select Course</label>
              <select id="course-select" class="form-input">
                <option value="">Choose a course...</option>
                <option value="cs101">Introduction to Computer Science</option>
                <option value="calc1">Calculus I</option>
                <option value="writing">Academic Writing Skills</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="rating">Overall Rating</label>
              <div class="rating-stars">
                <span class="star" data-rating="1">⭐</span>
                <span class="star" data-rating="2">⭐</span>
                <span class="star" data-rating="3">⭐</span>
                <span class="star" data-rating="4">⭐</span>
                <span class="star" data-rating="5">⭐</span>
              </div>
            </div>
            
            <div class="form-group">
              <label for="feedback-type">Feedback Type</label>
              <select id="feedback-type" class="form-input">
                <option value="general">General Feedback</option>
                <option value="teaching">Teaching Method</option>
                <option value="content">Course Content</option>
                <option value="assignment">Assignment Feedback</option>
                <option value="suggestion">Suggestion</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="feedback-message">Your Feedback</label>
              <textarea id="feedback-message" class="form-textarea" rows="5" placeholder="Share your thoughts, suggestions, or concerns..."></textarea>
            </div>
            
            <button type="submit" class="submit-feedback-btn">Submit Feedback</button>
          </form>
        </div>

        <!-- Feedback Statistics -->
        <div class="section-card">
          <h2 class="section-title">Quick Stats</h2>
          <p class="section-subtitle">Your feedback activity overview.</p>
          
          <div class="stats-list">
            <div class="stat-item">
              <span class="stat-label">Total Feedback Received</span>
              <span class="stat-value">24</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Evaluations Submitted</span>
              <span class="stat-value">11</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Average Grade</span>
              <span class="stat-value">B+</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Response Time</span>
              <span class="stat-value">2.3 days</span>
            </div>
          </div>
        </div>

        <!-- Action Items -->
        <div class="section-card">
          <h2 class="section-title">Action Items</h2>
          <p class="section-subtitle">Follow-up tasks based on recent feedback.</p>
          
          <div class="action-list">
            <div class="action-item">
              <div class="action-icon">📝</div>
              <div class="action-content">
                <h4>Improve Documentation</h4>
                <p>Add more comments to your CS101 code submissions</p>
                <span class="action-priority high">High Priority</span>
              </div>
            </div>
            
            <div class="action-item">
              <div class="action-icon">📅</div>
              <div class="action-content">
                <h4>Schedule Meeting</h4>
                <p>Meet with Ms. Jane Doe about writing structure</p>
                <span class="action-priority medium">Medium Priority</span>
              </div>
            </div>
            
            <div class="action-item">
              <div class="action-icon">📚</div>
              <div class="action-content">
                <h4>Practice Chain Rule</h4>
                <p>Complete additional calculus exercises</p>
                <span class="action-priority low">Low Priority</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Star rating functionality
    document.querySelectorAll('.star').forEach(star => {
      star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        const stars = this.parentElement.querySelectorAll('.star');
        
        stars.forEach((s, index) => {
          if (index < rating) {
            s.classList.add('selected');
          } else {
            s.classList.remove('selected');
          }
        });
      });
    });

    // Form submission
    document.querySelector('.feedback-form').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Feedback submitted successfully!');
    });
  </script>

</body>
</html>