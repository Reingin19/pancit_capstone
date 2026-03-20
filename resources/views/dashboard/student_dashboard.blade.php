<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Learning Assistant - Student Dashboard</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Dashboard & Chatbot Styles -->
    @vite([
        'resources/css/dashboard/student_dashboard.css', 
        'resources/css/dashboard/chatbot.css'


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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <span class="brand-name">Math Learning</span>
        </div>

        <nav class="sidebar-nav">
            <button class="sidebar-item active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Home
            </button>
            <button class="sidebar-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                Modules
            </button>
            <button class="sidebar-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                    <polyline points="17 6 23 6 23 12"/>
                </svg>
                Progress
            </button>
            <button class="sidebar-item">
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

    <!-- Hidden Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('student.logout') }}" style="display: none;">
        @csrf
    </form>

    <!-- ================================
         MAIN WRAPPER
         ================================ -->
    <div class="main-wrapper">

        <!-- Mobile / Tablet Header -->
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

        <!-- Main Content -->
        <main class="main-content">

            <!-- Hero -->
            <div class="hero-section">
                <h1 class="welcome-title">Welcome, Student!👋</h1>
                <p class="welcome-subtitle">Continue your mathematics learning journey</p>
            </div>

            <!-- Metrics -->
            <div class="metrics-scroll-wrap">
                <div class="metrics-grid">

                    <div class="metric-card">
                        <div class="metric-header">
                            <span class="metric-label">Overall Progress</span>
                            <div class="icon-container green-theme">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                    <polyline points="17 6 23 6 23 12"/>
                                </svg>
                            </div>
                        </div>
                        <div class="metric-value">0%</div>
                        <div class="metric-sub">Across all modules</div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-header">
                            <span class="metric-label">Quizzes Done</span>
                            <div class="icon-container orange-theme">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88"/>
                                    <circle cx="12" cy="8" r="7"/>
                                    <circle cx="12" cy="8" r="3"/>
                                </svg>
                            </div>
                        </div>
                        <div class="metric-value">0/20</div>
                        <div class="metric-sub">Keep going!</div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-header">
                            <span class="metric-label">Current Streak</span>
                            <div class="icon-container blue-theme">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <circle cx="12" cy="12" r="6"/>
                                    <circle cx="12" cy="12" r="2"/>
                                </svg>
                            </div>
                        </div>
                        <div class="metric-value">0</div>
                        <div class="metric-sub">days streak</div>
                    </div>

                </div>
            </div>

            <!-- Modules -->
            <section class="modules-container">
                <div class="section-label">Learning Modules</div>
                <div class="section-sub">Track your progress across all topics</div>

                <div class="module-item">
                    <div class="module-title-row">
                        <span class="status-icon">✓</span>
                        <span class="module-name">Sequences and Series</span>
                        <span class="percentage">100%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-fill" style="width: 100%;"></div>
                    </div>
                    <button class="view-topics-btn">View Topics</button>
                </div>

                <div class="module-item">
                    <div class="module-title-row">
                        <span class="status-icon">—</span>
                        <span class="module-name">Polynomials and Polynomial Equations</span>
                        <span class="percentage blue">0%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-fill blue" style="width: 0%;"></div>
                    </div>
                    <button class="view-topics-btn">View Topics</button>
                </div>

                <div class="module-item">
                    <div class="module-title-row">
                        <span class="status-icon">—</span>
                        <span class="module-name">Advanced Equations and Functions</span>
                        <span class="percentage blue">0%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-fill blue" style="width: 0%;"></div>
                    </div>
                    <button class="view-topics-btn">View Topics</button>
                </div>
            </section>

            <!-- Action Cards -->
            <div class="bottom-grid">

                <div class="action-card">
                    <div class="action-icon-wrap blue-theme">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        </main>
    </div>
</div>

<!-- ================================
     BOTTOM NAV (mobile/tablet only)
     ================================ -->
<nav class="bottom-nav">
    <button class="nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>Home</span>
        <div class="nav-dot"></div>
    </button>

    <button class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        <span>Modules</span>
    </button>

    <button class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
        </svg>
        <span>Progress</span>
    </button>

    <button class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Profile</span>
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

<!-- ================================
     CHATBOT WINDOW
     ================================ -->
<!-- ================================================
     CHATBOT PARTIAL
     ================================================ -->
@include('dashboard.chatbot')

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- Dashboard & Chatbot JS -->
@vite(['resources/js/dashboard/student_dashboard.js', 'resources/js/dashboard/chatbot.js'])

</body>
</html>