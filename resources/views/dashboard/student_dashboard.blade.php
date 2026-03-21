<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <title>Math Learning Assistant - Student Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Vite --}}
    @vite([
        'resources/css/dashboard/student_dashboard.css',
        'resources/css/dashboard/student_dashboard.js',
        'resources/css/dashboard/chatbot.css',
    ])
</head>
<body>
<div class="app-shell">

    <!-- DESKTOP SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <span class="brand-name">Math Learning</span>
        </div>

        <nav class="sidebar-nav">
            <button class="sidebar-item active" data-page="home">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Home
            </button>
            <button class="sidebar-item" data-page="modules">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                Modules
            </button>
            <button class="sidebar-item" data-page="progress">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                    <polyline points="17 6 23 6 23 12"/>
                </svg>
                Progress
            </button>
            <button class="sidebar-item" data-page="profile">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Profile
            </button>
        </nav>

        <div class="sidebar-fab">
            <button class="sidebar-fab-btn" id="sidebar-chat-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                AI Chat
            </button>
        </div>

        <div class="sidebar-logout">
            <button class="sidebar-logout-btn" id="logout-btn-desktop">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </div>
    </aside>

    {{-- Laravel logout form --}}
    <form id="logout-form" method="POST" action="{{ route('student.logout') }}" style="display:none;">
        @csrf
    </form>

    <div class="main-wrapper">

        <!-- MOBILE HEADER -->
        <header class="header">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <span class="brand-name">Math Learning Assistant</span>
            </div>
            <button class="logout-btn" id="logout-btn-mobile">Logout</button>
        </header>

        <main class="main-content">

            <!-- ==============================
                 HOME PAGE
                 ============================== -->
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
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                        <polyline points="17 6 23 6 23 12"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="metric-value" id="m-progress">0%</div>
                            <div class="metric-sub">Across all modules</div>
                        </div>

                        <div class="metric-card" onclick="navigate('modules')">
                            <div class="metric-header">
                                <span class="metric-label">Quizzes Done</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88"/>
                                        <circle cx="12" cy="8" r="7"/>
                                        <circle cx="12" cy="8" r="3"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="metric-value" id="m-quizzes">0/20</div>
                            <div class="metric-sub">Keep going!</div>
                        </div>

                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Current Streak</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <circle cx="12" cy="12" r="6"/>
                                        <circle cx="12" cy="12" r="2"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="metric-value" id="m-streak">0</div>
                            <div class="metric-sub">days streak</div>
                        </div>
                    </div>
                </div>

                <section class="modules-container">
                    <div class="section-label">Learning Modules</div>
                    <div class="section-sub">Track your progress across all topics</div>
                    <div id="home-module-list">
                        <div class="empty-state">
                            <div class="empty-icon">📚</div>
                            <h4>No modules yet</h4>
                            <p>Your learning modules will appear here once they are assigned.</p>
                        </div>
                    </div>
                    <button class="view-topics-btn" onclick="navigate('modules')" style="margin-top:10px">View All Modules</button>
                </section>

                <div class="bottom-grid">
                    <div class="action-card">
                        <div class="action-icon-wrap blue-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3>AI Chatbot</h3>
                            <p>Get instant help with your math questions</p>
                            <button id="start-chat-btn" class="primary-btn">Start Chat</button>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-icon-wrap green-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3>Offline Materials</h3>
                            <p>Download assessments to practice offline</p>
                            <button class="outline-btn">View Downloads</button>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-icon-wrap blue-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3>Summative Test</h3>
                            <p>Test your knowledge with an interactive summative assessment</p>
                            <button class="primary-btn">Start Summative Test</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================
                 MODULES PAGE
                 ============================== -->
            <div class="page" id="page-modules">
                <div class="hero-section">
                    <h1 class="welcome-title">Learning Modules</h1>
                    <p class="welcome-subtitle">Explore and continue your assigned topics</p>
                </div>

                <section class="modules-container">
                    <div class="section-label">All Modules</div>
                    <div class="section-sub">Track your progress across all topics</div>
                    <div id="modules-list">
                        <div class="empty-state">
                            <div class="empty-icon">📖</div>
                            <h4>No modules available</h4>
                            <p>Check back later for learning materials.</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- ==============================
                 PROGRESS PAGE
                 ============================== -->
            <div class="page" id="page-progress">
                <div class="hero-section">
                    <h1 class="welcome-title">My Progress</h1>
                    <p class="welcome-subtitle">See how far you've come in your learning journey</p>
                </div>

                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Overall</span>
                                <div class="icon-container green-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                        <polyline points="17 6 23 6 23 12"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="metric-value" id="p-overall">0%</div>
                            <div class="metric-sub">average progress</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Modules Done</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="metric-value" id="p-modules">0/0</div>
                            <div class="metric-sub">completed</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header">
                                <span class="metric-label">Quizzes Done</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88"/>
                                        <circle cx="12" cy="8" r="7"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="metric-value" id="p-quizzes">0/20</div>
                            <div class="metric-sub">quizzes finished</div>
                        </div>
                    </div>
                </div>

                <section class="modules-container">
                    <div class="section-label">Module Progress</div>
                    <div class="section-sub">Your progress in each learning module</div>
                    <div id="progress-list">
                        <div class="empty-state">
                            <div class="empty-icon">📈</div>
                            <h4>No progress data yet</h4>
                            <p>Complete some modules to see your progress here.</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- ==============================
                 PROFILE PAGE
                 ============================== -->
            <div class="page" id="page-profile">
                <div class="hero-section">
                    <h1 class="welcome-title">My Profile</h1>
                    <p class="welcome-subtitle">Manage your account and preferences</p>
                </div>

                <section class="modules-container">
                    <div class="section-label">Account Information</div>
                    <div class="section-sub">Update your personal details</div>
                    <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:16px">
                        <div>
                            <label style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.4px;display:block;margin-bottom:6px">Full Name</label>
                            <input type="text" id="p-name" placeholder="Your full name"
                                   maxlength="80" autocomplete="off"
                                   style="width:100%;padding:10px 14px;border:1px solid #e8ecf2;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:#f4f6fb;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.4px;display:block;margin-bottom:6px">Email Address</label>
                            <input type="email" id="p-email" placeholder="your@email.com"
                                   maxlength="120" autocomplete="off"
                                   style="width:100%;padding:10px 14px;border:1px solid #e8ecf2;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:#f4f6fb;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.4px;display:block;margin-bottom:6px">Grade / Section</label>
                            <input type="text" id="p-grade" placeholder="e.g. Grade 10 - Rizal"
                                   maxlength="80" autocomplete="off"
                                   style="width:100%;padding:10px 14px;border:1px solid #e8ecf2;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:#f4f6fb;outline:none;">
                        </div>
                    </div>
                    <div style="display:flex;justify-content:flex-end;gap:10px">
                        <button style="padding:10px 24px;border-radius:9px;font-family:inherit;font-weight:700;font-size:13px;cursor:pointer;background:white;border:1px solid #e8ecf2;color:#374151;">Cancel</button>
                        <button onclick="saveProfile()" style="padding:10px 24px;border-radius:9px;font-family:inherit;font-weight:700;font-size:13px;cursor:pointer;background:#2563eb;color:white;border:none;">Save Changes</button>
                    </div>
                </section>

                <section class="modules-container">
                    <div class="section-label">Recent Activity</div>
                    <div class="section-sub">Your latest completed activities</div>
                    <div id="profile-activity">
                        <div class="empty-state">
                            <div class="empty-icon">📋</div>
                            <h4>No recent activity</h4>
                            <p>Your completed quizzes and modules will appear here.</p>
                        </div>
                    </div>
                </section>
            </div>

        </main>
    </div>
</div>

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
    <button class="nav-item active" data-page="home">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>Home</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="modules">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        <span>Modules</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="progress">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
        </svg>
        <span>Progress</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="profile">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Profile</span>
        <div class="nav-dot"></div>
    </button>

    <!-- FAB Chat Button -->
    <div class="fab">
        <button class="fab-btn" id="fab-chat">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
        </button>
        <span class="fab-label">AI Chat</span>
    </div>
</nav>

{{-- Chatbot partial --}}
@include('dashboard.chatbot')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

@vite([
    'resources/js/dashboard/student_dashboard.js',
    'resources/js/dashboard/chatbot.js',
])
</body>
</html>