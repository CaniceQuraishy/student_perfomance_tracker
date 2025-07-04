<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPT - Peer Accountability</title>
  <link rel="stylesheet" href="assests/css/styles.css" />
  <link rel="stylesheet" href="assests/css/peer_accountability.css" />
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
      <a href="peer_accountability.php" class="sidebar-item active">👫 Peer Accountability</a>
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
      <h1>Peer Accountability Network</h1>
      <p>Connect with fellow students, share goals, and motivate each other to achieve academic excellence together.</p>
    </section>

    <!-- Peer Accountability Grid -->
    <div class="peer-grid">
      <!-- Left Column -->
      <div class="left-column">

        <!-- My Accountability Partners -->
        <div class="section-card">
          <div class="section-header">
            <div>
              <h2 class="section-title">My Accountability Partners</h2>
              <p class="section-subtitle">Stay connected with your study partners and track mutual progress.</p>
            </div>
            <button class="add-partner-btn" onclick="openAddPartnerModal()">+ Add Partner</button>
          </div>
          
          <div class="partners-list">
            <div class="partner-card">
              <div class="partner-header">
                <div class="partner-info">
                  <div class="avatar-circle large">A</div>
                  <div class="partner-details">
                    <h3>Alice Wonderland</h3>
                    <span class="partner-status online">Online</span>
                    <span class="partner-course">Computer Science</span>
                  </div>
                </div>
                <div class="partner-actions">
                  <button class="action-btn message" title="Send Message">💬</button>
                  <button class="action-btn video" title="Video Call">📹</button>
                  <button class="action-btn more" title="More Options">⋯</button>
                </div>
              </div>
              
              <div class="partner-stats">
                <div class="stat">
                  <span class="stat-label">Goals Met</span>
                  <span class="stat-value success">4</span>
                </div>
                <div class="stat">
                  <span class="stat-label">Pending</span>
                  <span class="stat-value warning">2</span>
                </div>
                <div class="stat">
                  <span class="stat-label">Failed</span>
                  <span class="stat-value danger">1</span>
                </div>
              </div>
              
              <div class="shared-goals">
                <h4>Shared Goals</h4>
                <div class="goal-tags">
                  <span class="goal-tag">CS101 Project</span>
                  <span class="goal-tag">Study Group</span>
                </div>
              </div>
            </div>

            <div class="partner-card">
              <div class="partner-header">
                <div class="partner-info">
                  <div class="avatar-circle large">B</div>
                  <div class="partner-details">
                    <h3>Bob The Builder</h3>
                    <span class="partner-status away">Away</span>
                    <span class="partner-course">Engineering</span>
                  </div>
                </div>
                <div class="partner-actions">
                  <button class="action-btn message" title="Send Message">💬</button>
                  <button class="action-btn video" title="Video Call">📹</button>
                  <button class="action-btn more" title="More Options">⋯</button>
                </div>
              </div>
              
              <div class="partner-stats">
                <div class="stat">
                  <span class="stat-label">Goals Met</span>
                  <span class="stat-value success">3</span>
                </div>
                <div class="stat">
                  <span class="stat-label">Pending</span>
                  <span class="stat-value warning">2</span>
                </div>
                <div class="stat">
                  <span class="stat-label">Failed</span>
                  <span class="stat-value danger">2</span>
                </div>
              </div>
              
              <div class="shared-goals">
                <h4>Shared Goals</h4>
                <div class="goal-tags">
                  <span class="goal-tag">Math Study</span>
                  <span class="goal-tag">Lab Report</span>
                </div>
              </div>
            </div>

            <div class="partner-card">
              <div class="partner-header">
                <div class="partner-info">
                  <div class="avatar-circle large">C</div>
                  <div class="partner-details">
                    <h3>Charlie Chaplin</h3>
                    <span class="partner-status offline">Offline</span>
                    <span class="partner-course">Film Studies</span>
                  </div>
                </div>
                <div class="partner-actions">
                  <button class="action-btn message" title="Send Message">💬</button>
                  <button class="action-btn video" title="Video Call">📹</button>
                  <button class="action-btn more" title="More Options">⋯</button>
                </div>
              </div>
              
              <div class="partner-stats">
                <div class="stat">
                  <span class="stat-label">Goals Met</span>
                  <span class="stat-value success">2</span>
                </div>
                <div class="stat">
                  <span class="stat-label">Pending</span>
                  <span class="stat-value warning">2</span>
                </div>
                <div class="stat">
                  <span class="stat-label">Failed</span>
                  <span class="stat-value danger">3</span>
                </div>
              </div>
              
              <div class="shared-goals">
                <h4>Shared Goals</h4>
                <div class="goal-tags">
                  <span class="goal-tag">Essay Writing</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Group Activities -->
        <div class="section-card">
          <h2 class="section-title">Recent Group Activities</h2>
          <p class="section-subtitle">Stay updated with your accountability network's progress.</p>
          
          <div class="activity-feed">
            <div class="activity-item">
              <div class="activity-avatar">A</div>
              <div class="activity-content">
                <p><strong>Alice Wonderland</strong> completed goal "CS101 Midterm Preparation"</p>
                <span class="activity-time">2 hours ago</span>
              </div>
              <div class="activity-badge success">✓</div>
            </div>
            
            <div class="activity-item">
              <div class="activity-avatar">B</div>
              <div class="activity-content">
                <p><strong>Bob The Builder</strong> requested accountability check for "Math Assignment"</p>
                <span class="activity-time">4 hours ago</span>
              </div>
              <div class="activity-badge warning">⏰</div>
            </div>
            
            <div class="activity-item">
              <div class="activity-avatar">You</div>
              <div class="activity-content">
                <p><strong>You</strong> shared progress update on "Academic Writing Skills"</p>
                <span class="activity-time">6 hours ago</span>
              </div>
              <div class="activity-badge info">📊</div>
            </div>
            
            <div class="activity-item">
              <div class="activity-avatar">C</div>
              <div class="activity-content">
                <p><strong>Charlie Chaplin</strong> missed deadline for "Film Analysis Essay"</p>
                <span class="activity-time">1 day ago</span>
              </div>
              <div class="activity-badge danger">✗</div>
            </div>
            
            <div class="activity-item">
              <div class="activity-avatar">A</div>
              <div class="activity-content">
                <p><strong>Alice Wonderland</strong> started a new study group for "Data Structures"</p>
                <span class="activity-time">2 days ago</span>
              </div>
              <div class="activity-badge info">👥</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="right-column">
        
        <!-- Quick Actions -->
        <div class="section-card">
          <h2 class="section-title">Quick Actions</h2>
          <p class="section-subtitle">Manage your accountability network.</p>
          
          <div class="quick-actions">
            <button class="quick-action-btn primary" onclick="openAddPartnerModal()">
              <span class="action-icon">👥</span>
              <span>Find Study Partners</span>
            </button>
            <button class="quick-action-btn secondary">
              <span class="action-icon">🎯</span>
              <span>Share a Goal</span>
            </button>
            <button class="quick-action-btn secondary">
              <span class="action-icon">📝</span>
              <span>Request Check-in</span>
            </button>
            <button class="quick-action-btn secondary">
              <span class="action-icon">📊</span>
              <span>View Group Progress</span>
            </button>
          </div>
        </div>

        <!-- Accountability Insights -->
        <div class="section-card">
          <h2 class="section-title">Your Accountability Insights</h2>
          <p class="section-subtitle">Track your accountability network performance.</p>
          
          <div class="insights-grid">
            <div class="insight-card">
              <div class="insight-icon">🤝</div>
              <div class="insight-content">
                <h3>Active Partners</h3>
                <span class="insight-number">3</span>
              </div>
            </div>
            
            <div class="insight-card">
              <div class="insight-icon">🎯</div>
              <div class="insight-content">
                <h3>Shared Goals</h3>
                <span class="insight-number">7</span>
              </div>
            </div>
            
            <div class="insight-card">
              <div class="insight-icon">⚡</div>
              <div class="insight-content">
                <h3>Motivation Score</h3>
                <span class="insight-number">89%</span>
              </div>
            </div>
            
            <div class="insight-card">
              <div class="insight-icon">📈</div>
              <div class="insight-content">
                <h3>Success Rate</h3>
                <span class="insight-number">76%</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests -->
        <div class="section-card">
          <h2 class="section-title">Pending Requests</h2>
          <p class="section-subtitle">Accountability partner requests and check-ins.</p>
          
          <div class="requests-list">
            <div class="request-item">
              <div class="request-info">
                <div class="avatar-circle small">D</div>
                <div class="request-details">
                  <h4>David Smith</h4>
                  <span>Wants to be accountability partners</span>
                </div>
              </div>
              <div class="request-actions">
                <button class="accept-btn">✓</button>
                <button class="decline-btn">✗</button>
              </div>
            </div>
            
            <div class="request-item">
              <div class="request-info">
                <div class="avatar-circle small">E</div>
                <div class="request-details">
                  <h4>Emma Watson</h4>
                  <span>Requests goal check-in</span>
                </div>
              </div>
              <div class="request-actions">
                <button class="respond-btn">Respond</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Study Groups -->
        <div class="section-card">
          <h2 class="section-title">Active Study Groups</h2>
          <p class="section-subtitle">Join or create study groups with your network.</p>
          
          <div class="study-groups">
            <div class="group-item">
              <div class="group-info">
                <h4>CS101 Study Group</h4>
                <span class="group-members">4 members</span>
                <span class="group-next">Next: Today 7:00 PM</span>
              </div>
              <button class="join-btn">Join</button>
            </div>
            
            <div class="group-item">
              <div class="group-info">
                <h4>Calculus Help Session</h4>
                <span class="group-members">6 members</span>
                <span class="group-next">Next: Tomorrow 3:00 PM</span>
              </div>
              <button class="join-btn">Join</button>
            </div>
            
            <div class="create-group">
              <button class="create-group-btn">+ Create New Study Group</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Add Partner Modal -->
  <div id="addPartnerModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Find Accountability Partner</h3>
        <button class="close-btn" onclick="closeAddPartnerModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="search-section">
          <input type="text" id="partnerSearch" class="search-input" placeholder="Search by name, course, or interests..." />
          <button class="search-btn">Search</button>
        </div>
        
        <div class="filter-section">
          <h4>Filter by:</h4>
          <div class="filter-options">
            <select class="filter-select">
              <option value="">All Courses</option>
              <option value="cs">Computer Science</option>
              <option value="math">Mathematics</option>
              <option value="eng">Engineering</option>
              <option value="writing">Writing</option>
            </select>
            <select class="filter-select">
              <option value="">Study Preference</option>
              <option value="group">Group Study</option>
              <option value="pair">Pair Study</option>
              <option value="online">Online Only</option>
            </select>
          </div>
        </div>
        
        <div class="suggestions-section">
          <h4>Suggested Partners</h4>
          <div class="partner-suggestions">
            <div class="suggestion-item">
              <div class="avatar-circle">M</div>
              <div class="suggestion-info">
                <h5>Mike Johnson</h5>
                <span>Computer Science • 87% success rate</span>
              </div>
              <button class="invite-btn">Invite</button>
            </div>
            
            <div class="suggestion-item">
              <div class="avatar-circle">S</div>
              <div class="suggestion-info">
                <h5>Sarah Wilson</h5>
                <span>Mathematics • 92% success rate</span>
              </div>
              <button class="invite-btn">Invite</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>