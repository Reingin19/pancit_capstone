<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <title>Math Learning Assistant - Teacher Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Vite: compiles teacher_dashboard.css + teacher_dashboard.js --}}
    @vite([
        'resources/css/dashboard/teacher_dashboard.css',
        'resources/js/dashboard/teacher_dashboard.js'
    ])
</head>
<body>
<div class="app-shell">

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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Home
        </button>

        <button class="sidebar-item" data-page="modules">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
            Modules
        </button>

        <button class="sidebar-item" data-page="students">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Students
        </button>

        <button class="sidebar-item" data-page="progress">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </svg>
            Progress
        </button>

        <button class="sidebar-item" data-page="reports">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Reports
        </button>

        <button class="sidebar-item" data-page="profile">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Profile
        </button>
    </nav>

    <div class="sidebar-logout">
        <button class="sidebar-logout-btn" id="logout-btn-desktop">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
        </button>
    </div>
</aside>
    {{-- Laravel logout form --}}
    <form id="logout-form" method="POST" action="{{ route('teacher.logout') }}" style="display:none;">
        @csrf
    </form>

    <div class="main-wrapper">

        <!-- MOBILE HEADER -->
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
            <button class="logout-btn" id="logout-btn-mobile">Logout</button>
        </header>

        <main class="main-content">

            <div class="page active" id="page-home">
    <div class="hero-section">
        <h1 class="welcome-title">Welcome, Teacher! 👋</h1>
        <p class="welcome-subtitle">Monitor and guide your students' learning journey</p>
    </div>

    <div class="metrics-scroll-wrap">
        <div class="metrics-grid">
            <div class="metric-card" onclick="navigate('students')">
                <div class="metric-header">
                    <span class="metric-label">Total Students</span>
                    <div class="icon-container blue-theme">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                </div>
                <div class="metric-value" id="m-total">0</div>
                <div class="metric-sub">Active learners</div>
            </div>

            <div class="metric-card" onclick="navigate('progress')">
                <div class="metric-header">
                    <span class="metric-label">Avg. Progress</span>
                    <div class="icon-container green-theme">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
                        </svg>
                    </div>
                </div>
                <div class="metric-value" id="m-avg">0%</div>
                <div class="metric-sub">Across all modules</div>
            </div>

            <div class="metric-card" onclick="navigate('reports')">
                <div class="metric-header">
                    <span class="metric-label">Pending Feedback</span>
                    <div class="icon-container orange-theme">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                </div>
                <div class="metric-value" id="m-pending">0</div>
                <div class="metric-sub">Awaiting review</div>
            </div>

            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-label">Messages</span>
                    <div class="icon-container purple-theme">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="metric-value" id="m-messages">0</div>
                <div class="metric-sub">Unread messages</div>
            </div>
        </div>
    </div>

    <section class="modules-container">
        <div class="section-label">Recent Student Activity</div>
        <div class="section-sub">Monitor your students' progress</div>
        <div id="home-student-list">
            <div class="empty-state">
                <div class="empty-icon">👩‍🎓</div>
                <h4>No students yet</h4>
                <p>Students will appear here once they enroll in your class.</p>
            </div>
        </div>
        <button class="view-topics-btn" onclick="navigate('students')">View All Students</button>
    </section>

    <div class="bottom-grid">
        <div class="action-card">
            <div class="action-icon-wrap blue-theme">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="action-content">
                <h3>Send Feedback</h3>
                <p>Give personalized recommendations to students</p>
                <button class="primary-btn" onclick="navigate('students')">Go to Students</button>
            </div>
        </div>

        <div class="action-card">
            <div class="action-icon-wrap green-theme">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
            </div>
            <div class="action-content">
                <h3>Print Materials</h3>
                <p>Download modules for offline distribution</p>
                <button class="outline-btn" onclick="generatePDF()">Generate PDFs</button>
            </div>
        </div>

        <div class="action-card">
            <div class="action-icon-wrap orange-theme">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="action-content">
                <h3>Generate Reports</h3>
                <p>Create detailed student performance reports</p>
                <button class="primary-btn" onclick="navigate('reports')">View Reports</button>
            </div>
        </div>

        <div class="action-card">
            <div class="action-icon-wrap purple-theme">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
                </svg>
            </div>
            <div class="action-content">
                <h3>Student Progress</h3>
                <p>Track and review each student's learning progress</p>
                <button class="primary-btn" onclick="navigate('progress')">View Progress</button>
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
        <p class="welcome-subtitle">Upload and manage your educational materials</p>
    </div>

    <div class="modules-container" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
        <div class="module-card-item" style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
            
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom: 24px;">
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Active Learning Topics</h2>
                    <p style="font-size: 0.875rem; color: #64748b;">Manage the materials available to your students</p>
                </div>
                <button class="add-btn" onclick="openModal('modal-upload-module')" style="background: #4f46e5; color: white; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.2s;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Upload Module
                </button>
            </div>

            <div id="teacher-modules-list" style="display: flex; flex-direction: column; gap: 12px;">
                <div style="text-align: center; padding: 40px 20px; border: 2px dashed #e2e8f0; border-radius: 10px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2" style="margin-bottom: 12px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <p style="color: #94a3b8; font-size: 0.9rem;">No modules uploaded yet. Click upload to start.</p>
                </div>
            </div>

        </div>
    </div>
</div>
            <!-- ==============================
                 STUDENTS PAGE
                 ============================== -->
            <div class="page" id="page-students">
                <div class="hero-section">
                    <h1 class="welcome-title">Students</h1>
                    <p class="welcome-subtitle">View, search, and send feedback to your students</p>
                </div>

                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Total</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="s-total">0</div>
                            <div class="metric-sub">enrolled students</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Avg. Progress</span>
                                <div class="icon-container green-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="s-avg">0%</div>
                            <div class="metric-sub">class average</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Need Help</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="s-help">0</div>
                            <div class="metric-sub">require attention</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Excellent</span>
                                <div class="icon-container purple-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="s-excellent">0</div>
                            <div class="metric-sub">top performers</div>
                        </div>
                    </div>
                </div>

                <div class="modules-container">
                    <div class="section-label">All Students</div>
                    <div class="section-sub">Search, filter, and manage your students</div>
                    <div class="toolbar">
                        <input type="text" class="search-input" id="student-search"
                               placeholder="🔍  Search by name…" oninput="filterStudents()"
                               maxlength="100" autocomplete="off">
                        <select class="filter-select" id="student-status-filter" onchange="filterStudents()">
                            <option value="">All Status</option>
                            <option value="Excellent">Excellent</option>
                            <option value="Good">Good</option>
                            <option value="Average">Average</option>
                            <option value="Needs Help">Needs Help</option>
                        </select>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Last Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="students-tbody"></tbody>
                        </table>
                    </div>
                    <div class="pagination" id="student-pagination"></div>
                </div>
            </div>

            <!-- ==============================
                 PROGRESS PAGE
                 ============================== -->
            <div class="page" id="page-progress">
    <div class="hero-section">
        <h1 class="welcome-title">Student Progress</h1>
        <p class="welcome-subtitle">Track and review each student's learning journey</p>
    </div>

    <div class="modules-container" style="margin-bottom: 2rem;">
        <div class="section-label">Student Performance Report</div>
        <div class="section-sub">Overview of all students' progress and status</div>
        
        <div style="display:flex; justify-content:flex-end; margin-bottom:14px">
            <button class="add-btn" onclick="generatePDF()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; display:inline; vertical-align:middle; margin-right:4px">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download PDF
            </button>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Feedbacks</th>
                    </tr>
                </thead>
                <tbody id="reports-tbody">
                    </tbody>
            </table>
        </div>
    </div>

    <div class="chart-container" style="margin-bottom: 2rem;">
        <div class="chart-title">Performance Distribution</div>
        <div class="chart-sub">Number of students per performance level</div>
        <div id="progress-chart">
            <div class="empty-state">
                <div class="empty-icon">📊</div>
                <h4>No data yet</h4>
                <p>Charts will appear as students complete activities.</p>
            </div>
        </div>
    </div>

    <div class="modules-container">
        <div class="section-label">Individual Progress</div>
        <div class="section-sub">How far each student has progressed</div>
        <div id="progress-list">
            <div class="empty-state">
                <div class="empty-icon">📈</div>
                <h4>No student data yet</h4>
                <p>Progress will appear here as students complete activities.</p>
            </div>
        </div>
    </div>
</div>

            <!-- ==============================
                 REPORTS PAGE
                 ============================== -->
            <div class="page" id="page-reports">
                <div class="hero-section">
                    <h1 class="welcome-title">Reports</h1>
                    <p class="welcome-subtitle">Generate and review detailed student performance reports</p>
                </div>

                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Students</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="r-total">0</div>
                            <div class="metric-sub">total enrolled</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Class Avg.</span>
                                <div class="icon-container green-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="r-avg">0%</div>
                            <div class="metric-sub">average progress</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-header"><span class="metric-label">Feedbacks</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="r-feedback">0</div>
                            <div class="metric-sub">feedbacks sent</div>
                        </div>
                    </div>
                </div>

                <div class="modules-container">
    <div class="section-label">Student Performance Reports by Section</div>
    <div class="section-sub">Overview of students grouped by their registered sections</div>
    
    <div style="display:flex; justify-content:flex-end; gap:10px; margin-bottom:14px">
        <button class="add-btn" onclick="addNewSection()" style="background-color: #4f46e5;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;display:inline;vertical-align:middle;margin-right:4px">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Section
        </button>

        <button class="add-btn" onclick="generatePDF()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; display:inline; vertical-align:middle; margin-right:4px">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download PDF Report
        </button>
    </div>

    <div id="sections-wrapper">
        <div class="table-section-group" style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 10px; color: var(--accent);">📍 Section 1</h3>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody id="section-1-tbody"></tbody>
                </table>
            </div>
        </div>

        <div class="table-section-group" style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 10px; color: var(--accent);">📍 Section 2</h3>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody id="section-2-tbody"></tbody>
                </table>
            </div>
        </div>

        <div class="table-section-group" style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 10px; color: var(--accent);">📍 Section 3</h3>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody id="section-3-tbody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

            <!-- ==============================
                 PROFILE PAGE
                 ============================== -->
            <div class="page" id="page-profile">
                <div class="hero-section">
                    <h1 class="welcome-title">My Profile</h1>
                    <p class="welcome-subtitle">Manage your account and preferences</p>
                </div>

                <div class="modules-container">
                    <div class="section-label">Account Information</div>
                    <div class="section-sub">Update your personal details</div>
                    <div class="field-row">
                        <label>Full Name</label>
                        <input type="text" id="p-name" placeholder="Your full name" maxlength="80" autocomplete="off">
                    </div>
                    <div class="field-row">
                        <label>Email Address</label>
                        <input type="email" id="p-email" placeholder="your@email.com" maxlength="120" autocomplete="off">
                    </div>
                    <div class="field-row">
                        <label>Subject / Department</label>
                        <input type="text" id="p-subject" placeholder="e.g. Mathematics" maxlength="80" autocomplete="off">
                    </div>
                    <div class="save-row">
                        <button class="btn-cancel">Cancel</button>
                        <button class="btn-save" onclick="saveProfile()">Save Changes</button>
                    </div>
                </div>

                <div class="modules-container">
                    <div class="section-label">Recent Activity</div>
                    <div class="section-sub">Your latest actions on the platform</div>
                    <div id="profile-activity">
                        <div class="empty-state">
                            <div class="empty-icon">📋</div>
                            <h4>No recent activity</h4>
                            <p>Your actions will appear here.</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>



<nav class="bottom-nav">
    <button class="nav-item active" data-page="home">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Home</span>
        <div class="nav-dot"></div>
    </button>
    
    <button class="nav-item" data-page="modules">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </svg>
        <span>Modules</span>
        <div class="nav-dot"></div>
    </button>

    <button class="nav-item" data-page="students">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span>Students</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="progress">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        <span>Progress</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="reports">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <span>Reports</span>
        <div class="nav-dot"></div>
    </button>
    <button class="nav-item" data-page="profile">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Profile</span>
        <div class="nav-dot"></div>
    </button>
</nav>

<!-- SEND FEEDBACK MODAL -->
<div class="modal-overlay" id="modal-feedback">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Send Feedback</span>
            <button class="modal-close" onclick="closeModal('modal-feedback')">✕</button>
        </div>
        <p style="font-size:13px;color:var(--text-3);margin-bottom:16px">
            To: <strong id="fb-student-name" style="color:var(--text)"></strong>
        </p>
        <div class="field-row">
            <label>Feedback Type</label>
            <select id="fb-type">
                <option value="encouragement">Encouragement</option>
                <option value="improvement">Needs Improvement</option>
                <option value="praise">Praise</option>
                <option value="reminder">Reminder</option>
            </select>
        </div>
        <div class="field-row">
            <label>Message</label>
            <textarea id="fb-message" rows="4"
                      placeholder="Write your feedback message here…"
                      maxlength="500"></textarea>
        </div>
        <div class="save-row">
            <button class="btn-cancel" onclick="closeModal('modal-feedback')">Cancel</button>
            <button class="btn-save" onclick="saveFeedback()">Send Feedback</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<div id="modal-upload-module" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; padding:30px; border-radius:15px; width:90%; max-width:400px; position:relative;">
        <h2 style="margin-top:0;">Upload Module</h2>
        
        <form onsubmit="handleUpload(event)">
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Module Title</label>
                <input type="text" id="m-title" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">PDF File</label>
                <input type="file" id="m-file" accept="application/pdf" required style="width:100%;">
            </div>
            <div style="display:flex; gap:10px;">
                <button type="button" onclick="closeModal('modal-upload-module')" style="flex:1; padding:10px; background:#eee; border:none; border-radius:5px; cursor:pointer;">Cancel</button>
                <button type="submit" id="btn-upload-submit" style="flex:1; padding:10px; background:#4f46e5; color:white; border:none; border-radius:5px; cursor:pointer;">Upload Now</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-preview-pdf" style="display:none; padding: 20px;">
    <div style="background: white; width: 95%; height: 95%; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; background: #fff;">
            <h3 id="preview-title" style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #1e293b;">arithmeticSequence.pdf</h3>
            <button onclick="closeModal('modal-preview-pdf')" style="background: #f1f5f9; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #475569;">Close</button>
        </div>
        <div style="flex-grow: 1; width: 100%; height: 100%;">
            <iframe id="pdf-viewer" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>
</div>

</body>
</html>