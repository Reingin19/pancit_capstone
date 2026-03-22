<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Learning Assistant - Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite([
        'resources/css/dashboard/student_dashboard.css',
        'resources/js/dashboard/student_dashboard.js',
        'resources/css/dashboard/chatbot.css',
    ])
</head>
<body>

<div class="app-shell">

    <!-- ================================
         DESKTOP SIDEBAR
         ================================ -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <span class="brand-name">Math Learning</span>
        </div>

        <nav class="sidebar-nav">
            <button class="sidebar-item active" data-page="home">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home
            </button>
            <button class="sidebar-item" data-page="modules">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Modules
            </button>
            <button class="sidebar-item" data-page="progress">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Progress
            </button>
            <button class="sidebar-item" data-page="profile">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profile
            </button>
        </nav>

        <div class="sidebar-fab">
            <button class="sidebar-fab-btn" id="sidebar-chat-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                AI Chat
            </button>
        </div>

        <div class="sidebar-logout">
            <button class="sidebar-logout-btn" onclick="confirmLogout()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </div>
    </aside>

    <!-- ================================
         MAIN WRAPPER
         ================================ -->
    <div class="main-wrapper">

        <!-- Mobile / Tablet Header -->
        <header class="header">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <span class="brand-name">Math Learning Assistant</span>
            </div>
            <button class="logout-btn" onclick="confirmLogout()">Logout</button>
        </header>

        <main class="main-content">

            <!-- ===== HOME PAGE ===== -->
            <div class="page active" id="page-home">
                <div class="hero-section">
                    <h1 class="welcome-title">Welcome, Student! 👋</h1>
                    <p class="welcome-subtitle">Continue your mathematics learning journey</p>
                </div>

                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card" onclick="navigate('progress')">
                            <div class="metric-header">
                                <span class="metric-label">Overall Progress</span>
                                <div class="icon-container green-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                </div>
                            </div>
                            <div class="metric-value">0%</div>
                            <div class="metric-sub">across all modules</div>
                        </div>
                        <div class="metric-card" onclick="navigate('modules')">
                            <div class="metric-header">
                                <span class="metric-label">Quizzes Done</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88"/><circle cx="12" cy="8" r="7"/><circle cx="12" cy="8" r="3"/></svg>
                                </div>
                            </div>
                            <div class="metric-value">0/20</div>
                            <div class="metric-sub">keep going!</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Current Streak</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                </div>
                            </div>
                            <div class="metric-value">0</div>
                            <div class="metric-sub">days streak</div>
                        </div>
                    </div>
                </div>

                <section class="modules-container">
                    <div class="section-label">Learning Modules</div>
                    <div class="section-sub">Track your progress across all topics</div>

                    <div class="module-item">
                        <div class="module-title-row">
                            <span class="status-icon">—</span>
                            <span class="module-name">Sequences and Series</span>
                            <span class="percentage blue">0%</span>
                        </div>
                        <div class="progress-bar-bg"><div class="progress-fill blue" style="width:0%"></div></div>
                        <button class="view-topics-btn" onclick="navigate('modules')">View Topics</button>
                    </div>

                    <div class="module-item">
                        <div class="module-title-row">
                            <span class="status-icon">—</span>
                            <span class="module-name">Polynomials and Polynomial Equations</span>
                            <span class="percentage blue">0%</span>
                        </div>
                        <div class="progress-bar-bg"><div class="progress-fill blue" style="width:0%"></div></div>
                        <button class="view-topics-btn" onclick="navigate('modules')">View Topics</button>
                    </div>

                    <div class="module-item">
                        <div class="module-title-row">
                            <span class="status-icon">—</span>
                            <span class="module-name">Advanced Equations and Functions</span>
                            <span class="percentage blue">0%</span>
                        </div>
                        <div class="progress-bar-bg"><div class="progress-fill blue" style="width:0%"></div></div>
                        <button class="view-topics-btn" onclick="navigate('modules')">View Topics</button>
                    </div>
                </section>

                <div class="bottom-grid">
                    <div class="action-card">
                        <div class="action-icon-wrap blue-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>AI Chatbot</h3>
                            <p>Get instant help with your math questions</p>
                            <button class="primary-btn" id="start-chat-btn">Start Chat</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap green-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>Offline Materials</h3>
                            <p>Download assessments to practice offline</p>
                            <button class="outline-btn" onclick="navigate('downloads')">View Downloads</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap blue-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>Summative Test</h3>
                            <p>Test your knowledge with an interactive summative assessment</p>
                            <button class="primary-btn" onclick="navigate('summative')">Start Summative Test</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== MODULES PAGE ===== -->
            <div class="page" id="page-modules">
                <div class="hero-section">
                    <h1 class="welcome-title">Learning Modules</h1>
                    <p class="welcome-subtitle">Explore topics and start learning</p>
                </div>

                <section class="modules-container">
                    <div class="section-label">Module 1: Sequences and Series</div>
                    <div class="section-sub">0% complete · 0 of 6 topics done</div>
                    <ul class="topic-list">
                        <li class="topic-item"><span class="topic-dot"></span>Arithmetic Sequences</li>
                        <li class="topic-item"><span class="topic-dot"></span>Geometric Sequences</li>
                        <li class="topic-item"><span class="topic-dot"></span>Sum of Arithmetic Series</li>
                        <li class="topic-item"><span class="topic-dot"></span>Sum of Geometric Series</li>
                        <li class="topic-item"><span class="topic-dot"></span>Infinite Geometric Series</li>
                        <li class="topic-item"><span class="topic-dot"></span>Applications of Sequences</li>
                    </ul>
                </section>

                <section class="modules-container">
                    <div class="section-label">Module 2: Polynomials and Polynomial Equations</div>
                    <div class="section-sub">0% complete · 0 of 5 topics done</div>
                    <ul class="topic-list">
                        <li class="topic-item"><span class="topic-dot"></span>Introduction to Polynomials</li>
                        <li class="topic-item"><span class="topic-dot"></span>Operations on Polynomials</li>
                        <li class="topic-item"><span class="topic-dot"></span>Factoring Polynomials</li>
                        <li class="topic-item"><span class="topic-dot"></span>Polynomial Equations</li>
                        <li class="topic-item"><span class="topic-dot"></span>Remainder &amp; Factor Theorem</li>
                    </ul>
                </section>

                <section class="modules-container">
                    <div class="section-label">Module 3: Advanced Equations and Functions</div>
                    <div class="section-sub">0% complete · 0 of 5 topics done</div>
                    <ul class="topic-list">
                        <li class="topic-item"><span class="topic-dot"></span>Rational Equations</li>
                        <li class="topic-item"><span class="topic-dot"></span>Radical Equations</li>
                        <li class="topic-item"><span class="topic-dot"></span>Exponential Functions</li>
                        <li class="topic-item"><span class="topic-dot"></span>Logarithmic Functions</li>
                        <li class="topic-item"><span class="topic-dot"></span>Systems of Equations</li>
                    </ul>
                </section>
            </div>

            <!-- ===== PROGRESS PAGE ===== -->
            <div class="page" id="page-progress">
                <div class="hero-section">
                    <h1 class="welcome-title">My Progress</h1>
                    <p class="welcome-subtitle">See how far you've come</p>
                </div>

                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Overall</span>
                                <div class="icon-container green-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                </div>
                            </div>
                            <div class="metric-value">0%</div>
                            <div class="metric-sub">all modules</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Topics Done</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                </div>
                            </div>
                            <div class="metric-value">0/16</div>
                            <div class="metric-sub">total topics</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Quizzes</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88"/><circle cx="12" cy="8" r="7"/></svg>
                                </div>
                            </div>
                            <div class="metric-value">0/20</div>
                            <div class="metric-sub">completed</div>
                        </div>
                    </div>
                </div>

                <section class="modules-container">
                    <div class="section-label">Module Progress</div>
                    <div class="section-sub">Detailed breakdown by module</div>

                    <div class="progress-row">
                        <div class="progress-label"><span>Sequences and Series</span><span>0%</span></div>
                        <div class="progress-bar"><div class="progress-fill-bar" style="width:0%; background:var(--blue)"></div></div>
                    </div>
                    <div class="progress-row">
                        <div class="progress-label"><span>Polynomials and Polynomial Equations</span><span>0%</span></div>
                        <div class="progress-bar"><div class="progress-fill-bar" style="width:0%; background:var(--orange)"></div></div>
                    </div>
                    <div class="progress-row" style="margin-bottom:0">
                        <div class="progress-label"><span>Advanced Equations and Functions</span><span>0%</span></div>
                        <div class="progress-bar"><div class="progress-fill-bar" style="width:0%; background:var(--purple)"></div></div>
                    </div>
                </section>

                <section class="modules-container">
                    <div class="section-label">Recent Activity</div>
                    <div class="section-sub">Your latest learning events</div>
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <h4>No activity yet</h4>
                        <p>Start a module to track your progress here.</p>
                    </div>
                </section>
            </div>

            <!-- ===== PROFILE PAGE ===== -->
            <div class="page" id="page-profile">
                <div class="hero-section">
                    <h1 class="welcome-title">My Profile</h1>
                    <p class="welcome-subtitle">Manage your account and preferences</p>
                </div>

                <div class="profile-card">
                    <div class="profile-avatar">S</div>
                    <div class="profile-name">Student</div>
                    <div class="profile-email">student@mathlearning.edu</div>
                    <span class="profile-badge">Student</span>
                </div>

                <div class="settings-section">
                    <h3>Account Information</h3>
                    <p class="desc">Update your personal details</p>
                    <div class="field-row">
                        <label>Full Name</label>
                        <input type="text" value="Student" placeholder="Your full name">
                    </div>
                    <div class="field-row">
                        <label>Email Address</label>
                        <input type="email" value="student@mathlearning.edu" placeholder="Your email">
                    </div>
                    <div class="field-row">
                        <label>Section / Class</label>
                        <input type="text" value="" placeholder="e.g. Grade 10 — Rizal">
                    </div>
                    <div class="save-row">
                        <button class="btn-cancel">Cancel</button>
                        <button class="btn-save" onclick="toast('success','Profile updated!')">Save Changes</button>
                    </div>
                </div>

                <div class="settings-section">
                    <h3>Change Password</h3>
                    <p class="desc">Keep your account secure</p>
                    <div class="field-row">
                        <label>Current Password</label>
                        <input type="password" placeholder="••••••••">
                    </div>
                    <div class="field-row">
                        <label>New Password</label>
                        <input type="password" placeholder="••••••••">
                    </div>
                    <div class="field-row">
                        <label>Confirm New Password</label>
                        <input type="password" placeholder="••••••••">
                    </div>
                    <div class="save-row">
                        <button class="btn-cancel">Cancel</button>
                        <button class="btn-save" onclick="toast('success','Password changed!')">Update Password</button>
                    </div>
                </div>
            </div>

            <!-- ===== DOWNLOADS PAGE ===== -->
            <div class="page" id="page-downloads">
                <div class="hero-section">
                    <h1 class="welcome-title">Offline Materials 📥</h1>
                    <p class="welcome-subtitle">Download assessments and worksheets to practice offline</p>
                </div>

                <section class="modules-container">
                    <div class="section-label">Module 1 — Sequences and Series</div>
                    <div class="section-sub">Practice worksheets and assessment sheets</div>
                    <div class="download-item">
                        <div class="download-icon green-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="download-info">
                            <span class="download-name">Arithmetic &amp; Geometric Sequences Worksheet</span>
                            <span class="download-meta">PDF · 2 pages · 128 KB</span>
                        </div>
                        <button class="dl-btn" onclick="toast('success','Download started!')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                    <div class="download-item">
                        <div class="download-icon green-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="download-info">
                            <span class="download-name">Series Summation Quiz Sheet</span>
                            <span class="download-meta">PDF · 1 page · 84 KB</span>
                        </div>
                        <button class="dl-btn" onclick="toast('success','Download started!')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                </section>

                <section class="modules-container">
                    <div class="section-label">Module 2 — Polynomials and Polynomial Equations</div>
                    <div class="section-sub">Practice worksheets and assessment sheets</div>
                    <div class="download-item">
                        <div class="download-icon orange-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="download-info">
                            <span class="download-name">Polynomial Operations Practice Sheet</span>
                            <span class="download-meta">PDF · 3 pages · 210 KB</span>
                        </div>
                        <button class="dl-btn" onclick="toast('success','Download started!')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                    <div class="download-item">
                        <div class="download-icon orange-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="download-info">
                            <span class="download-name">Remainder &amp; Factor Theorem Worksheet</span>
                            <span class="download-meta">PDF · 2 pages · 156 KB</span>
                        </div>
                        <button class="dl-btn" onclick="toast('success','Download started!')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                </section>

                <section class="modules-container">
                    <div class="section-label">Module 3 — Advanced Equations and Functions</div>
                    <div class="section-sub">Practice worksheets and assessment sheets</div>
                    <div class="download-item">
                        <div class="download-icon purple-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="download-info">
                            <span class="download-name">Exponential &amp; Logarithmic Functions Sheet</span>
                            <span class="download-meta">PDF · 2 pages · 175 KB</span>
                        </div>
                        <button class="dl-btn" onclick="toast('success','Download started!')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                    <div class="download-item">
                        <div class="download-icon purple-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="download-info">
                            <span class="download-name">Systems of Equations Practice Quiz</span>
                            <span class="download-meta">PDF · 1 page · 98 KB</span>
                        </div>
                        <button class="dl-btn" onclick="toast('success','Download started!')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                </section>
            </div>

            <!-- ===== SUMMATIVE TEST PAGE ===== -->
            <div class="page" id="page-summative">
                <div class="hero-section">
                    <h1 class="welcome-title">Summative Test 📋</h1>
                    <p class="welcome-subtitle">Answer all questions carefully. You can review before submitting.</p>
                </div>

                <div id="quiz-start-screen">
                    <section class="modules-container">
                        <div class="section-label">Test Instructions</div>
                        <div class="section-sub">Read before you begin</div>
                        <div class="download-item" style="border:none; padding:0; margin-bottom:10px;">
                            <div class="download-icon blue-theme">📖</div>
                            <div class="download-info"><span class="download-name">This test covers all 3 modules.</span><span class="download-meta">Sequences · Polynomials · Advanced Equations</span></div>
                        </div>
                        <div class="download-item" style="border:none; padding:0; margin-bottom:10px;">
                            <div class="download-icon orange-theme">❓</div>
                            <div class="download-info"><span class="download-name">10 multiple choice questions</span><span class="download-meta">Choose the best answer for each item</span></div>
                        </div>
                        <div class="download-item" style="border:none; padding:0; margin-bottom:0;">
                            <div class="download-icon green-theme">✅</div>
                            <div class="download-info"><span class="download-name">Review your answers before submitting</span><span class="download-meta">You can go back and change answers anytime</span></div>
                        </div>
                    </section>
                    <button class="primary-btn" style="max-width:320px; margin:0 auto; display:block; padding:14px; font-size:15px;" onclick="startQuiz()">Begin Summative Test →</button>
                </div>

                <div id="quiz-question-screen" style="display:none;">
                    <div class="modules-container" id="quiz-card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <span class="section-label" id="quiz-q-label">Question 1 of 10</span>
                            <span class="profile-badge" id="quiz-score-badge">Score: 0</span>
                        </div>
                        <div style="background:var(--border); border-radius:99px; height:6px; margin-bottom:20px; overflow:hidden;">
                            <div id="quiz-progress-bar" style="height:100%; background:var(--blue); border-radius:99px; width:10%; transition:width 0.4s ease;"></div>
                        </div>
                        <p id="quiz-question-text" style="font-size:15px; font-weight:700; color:var(--text); line-height:1.5; margin-bottom:20px;"></p>
                        <div id="quiz-choices" style="display:flex; flex-direction:column; gap:10px;"></div>
                        <div style="display:flex; justify-content:flex-end; margin-top:20px; gap:10px;">
                            <button class="outline-btn" id="quiz-prev-btn" style="max-width:120px;" onclick="quizPrev()">← Back</button>
                            <button class="primary-btn" id="quiz-next-btn" style="max-width:160px;" onclick="quizNext()">Next →</button>
                        </div>
                    </div>
                </div>

                <div id="quiz-result-screen" style="display:none; text-align:center;">
                    <section class="modules-container">
                        <div id="quiz-result-emoji" style="font-size:56px; margin-bottom:12px;">🎉</div>
                        <div class="section-label" id="quiz-result-title">Test Complete!</div>
                        <div class="section-sub" id="quiz-result-sub">Here's how you did</div>
                        <div style="font-size:52px; font-weight:800; color:var(--blue); letter-spacing:-2px; margin:16px 0;" id="quiz-result-score"></div>
                        <div style="font-size:14px; color:var(--text-3); margin-bottom:24px;" id="quiz-result-msg"></div>
                        <button class="primary-btn" style="max-width:240px; margin:0 auto;" onclick="retakeQuiz()">Retake Test</button>
                    </section>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- ================================
     BOTTOM NAV (mobile/tablet only)
     ================================ -->
<nav class="bottom-nav">
    <button class="nav-item active" data-page="home">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Home</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="modules">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        <span>Modules</span>
        <div class="nav-dot"></div>
    </button>
    <div class="fab">
        <button class="fab-btn" id="fab-chat">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </button>
        <span class="fab-label">AI Chat</span>
    </div>
    <button class="nav-item" data-page="progress">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        <span>Progress</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="profile">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Profile</span>
        <div class="nav-dot"></div>
    </button>
</nav>

<!-- ================================================
     CHATBOT
     ================================================ -->
<div id="ai-chat-window" class="chat-window-compact">
    <div class="chat-header">
        <div class="user-info">
            <div class="chat-avatar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div class="chat-info">
                <span class="chat-name">Math AI Assistant</span>
                <span class="chat-status-text">Online</span>
            </div>
        </div>
        <button id="close-chat">&times;</button>
    </div>

    <div id="chat-content" class="chat-content">
        <div class="msg bot">
            <div class="msg-bubble">Hello! I'm here to help you with your math questions. Ask me about <strong>Sequences</strong>, <strong>Polynomials</strong>, or <strong>Functions</strong>.</div>
            <div class="quick-replies">
                <button class="quick-reply-btn">Sequences</button>
                <button class="quick-reply-btn">Polynomials</button>
                <button class="quick-reply-btn">Functions</button>
            </div>
            <span class="msg-time">Just now</span>
        </div>
    </div>

    <div class="chat-footer">
        <div class="input-row">
            <input type="text" id="ai-input" placeholder="Type your question...">
            <button id="ai-send-btn" title="Send message">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN (pwede ring i-npm install) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

</body>
</html>