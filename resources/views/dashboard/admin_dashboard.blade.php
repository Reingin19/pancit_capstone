<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Math Learning Assistant - Admin Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS via CDN (reliable fallback) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Vite: compiles admin_dashboard.css + admin_dashboard.js --}}
    @vite([
        'resources/css/dashboard/admin_dashboard.css',
        'resources/js/dashboard/admin_dashboard.js'
    ])
</head>
<body>
<div class="app-shell">

    <!-- DESKTOP SIDEBAR -->
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
            <button class="sidebar-item" data-page="users">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Users
            </button>
            <button class="sidebar-item" data-page="analytics">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Analytics
            </button>
            <button class="sidebar-item" data-page="content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Content
            </button>
            <button class="sidebar-item" data-page="activity">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Activity
            </button>
            <button class="sidebar-item" data-page="settings">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Settings
            </button>
        </nav>
        <div class="sidebar-logout">
            <button class="sidebar-logout-btn" onclick="confirmLogout()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </div>
    </aside>

    {{-- Laravel logout form --}}
    <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display:none;">
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
            <button class="logout-btn" onclick="confirmLogout()">Logout</button>
        </header>

        <main class="main-content">

            <!-- HOME PAGE -->
            <div class="page active" id="page-home">
                <div class="hero-section">
                    <h1 class="welcome-title">System Administration</h1>
                    <p class="welcome-subtitle">Manage users, permissions, and platform settings</p>
                </div>

                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card" onclick="navigate('users')">
                            <div class="metric-header">
                                <span class="metric-label">Total Users</span>
                                <div class="icon-container blue-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="m-total">0</div>
                            <div class="metric-sub">registered accounts</div>
                        </div>
                        <div class="metric-card" onclick="navigate('users')">
                            <div class="metric-header">
                                <span class="metric-label">Active Students</span>
                                <div class="icon-container green-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="m-students">0</div>
                            <div class="metric-sub">enrolled learners</div>
                        </div>
                        <div class="metric-card" onclick="navigate('users')">
                            <div class="metric-header">
                                <span class="metric-label">Teachers</span>
                                <div class="icon-container orange-theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                            </div>
                            <div class="metric-value" id="m-teachers">0</div>
                            <div class="metric-sub">active educators</div>
                        </div>
                    </div>
                </div>

                <section class="modules-container">
                    <div class="section-label">Recent System Activity</div>
                    <div class="section-sub">Latest user registrations and system events</div>
                    <div id="home-activity-log">
                        <div class="empty-state">
                            <div class="empty-icon">📋</div>
                            <h4>No activity yet</h4>
                            <p>Events will appear here as users interact with the platform.</p>
                        </div>
                    </div>
                    <button class="view-topics-btn" onclick="navigate('activity')">View All Activity</button>
                </section>

                <div class="bottom-grid">
                    <div class="action-card">
                        <div class="action-icon-wrap blue-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>User Management</h3>
                            <p>Manage accounts, roles, and permissions</p>
                            <button class="primary-btn" onclick="navigate('users')">Manage Users</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap green-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>Roles &amp; Permissions</h3>
                            <p>Configure access levels and privileges</p>
                            <button class="outline-btn" onclick="navigate('settings')">Configure Roles</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap orange-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>Analytics</h3>
                            <p>View platform usage and performance metrics</p>
                            <button class="primary-btn" onclick="navigate('analytics')">View Analytics</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap purple-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>Activity Tracking</h3>
                            <p>Monitor active users and engagement</p>
                            <button class="primary-btn" onclick="navigate('activity')">Track Activity</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap green-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>Content Management</h3>
                            <p>Manage learning modules and materials</p>
                            <button class="outline-btn" onclick="navigate('content')">Manage Content</button>
                        </div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon-wrap orange-theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <div class="action-content">
                            <h3>System Settings</h3>
                            <p>Configure platform preferences and features</p>
                            <button class="primary-btn" onclick="navigate('settings')">System Settings</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USERS PAGE -->
            <div class="page" id="page-users">
                <div class="hero-section">
                    <h1 class="welcome-title">User Management</h1>
                    <p class="welcome-subtitle">Manage all registered users, roles, and account status</p>
                </div>
                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Total Users</span><div class="icon-container blue-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div></div><div class="metric-value" id="u-total">0</div><div class="metric-sub">registered accounts</div></div>
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Students</span><div class="icon-container green-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></div></div><div class="metric-value" id="u-students">0</div><div class="metric-sub">enrolled learners</div></div>
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Teachers</span><div class="icon-container orange-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div></div><div class="metric-value" id="u-teachers">0</div><div class="metric-sub">active educators</div></div>
                    </div>
                </div>
                <div class="modules-container">
                    <div class="section-label">All Users</div>
                    <div class="section-sub">Search, filter, and manage user accounts</div>
                    <div class="toolbar">
                        <input type="text" class="search-input" id="user-search" placeholder="🔍  Search by name or email…" oninput="filterUsers()" maxlength="100" autocomplete="off">
                        <select class="filter-select" id="user-role-filter" onchange="filterUsers()">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                        <button class="add-btn" onclick="openAddUser()">+ Add User</button>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody id="users-tbody"></tbody>
                        </table>
                    </div>
                    <div class="pagination" id="user-pagination"></div>
                </div>
            </div>

            <!-- ANALYTICS PAGE -->
            <div class="page" id="page-analytics">
                <div class="hero-section">
                    <h1 class="welcome-title">Analytics</h1>
                    <p class="welcome-subtitle">Platform usage, engagement, and performance metrics</p>
                </div>
                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Daily Active</span><div class="icon-container green-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div></div><div class="metric-value" id="a-dau">0</div><div class="metric-sub">users today</div></div>
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Avg. Score</span><div class="icon-container purple-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div></div><div class="metric-value" id="a-score">—</div><div class="metric-sub">platform average</div></div>
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Modules Done</span><div class="icon-container orange-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div></div><div class="metric-value" id="a-completions">0</div><div class="metric-sub">total completions</div></div>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-title">Weekly User Registrations</div>
                    <div class="chart-sub">New signups per day over the last 7 days</div>
                    <div id="reg-chart">
                        <div class="empty-state"><div class="empty-icon">📊</div><h4>No registration data yet</h4><p>Charts will populate as users join.</p></div>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-title">Subject Completion Rates</div>
                    <div class="chart-sub">How far students have progressed in each subject</div>
                    <div id="subject-progress">
                        <div class="empty-state"><div class="empty-icon">📈</div><h4>No progress data yet</h4><p>Data appears as students complete modules.</p></div>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-title">User Distribution</div>
                    <div class="chart-sub">Breakdown of platform roles</div>
                    <div id="donut-row">
                        <div class="empty-state"><div class="empty-icon">🍩</div><h4>No users yet</h4><p>Add users to see role distribution.</p></div>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-title">Top Performing Students</div>
                    <div class="chart-sub">Students with the highest overall scores</div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Rank</th><th>Student</th><th>Score</th><th>Modules</th><th>Streak</th></tr></thead>
                            <tbody id="top-students-tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

           <div class="page" id="page-content">
    <div class="hero-section">
        <h1 class="welcome-title">Content Management</h1>
        <p class="welcome-subtitle">Manage learning modules, topics, and materials</p>
    </div>
    
    <div class="modules-container">
        <div class="section-label">Learning Modules</div>
        <div class="section-sub">All published and draft modules</div>
        
        <div class="toolbar">
            <input type="text" class="search-input" id="content-search" placeholder="🔍 Search modules…" oninput="filterContent()" maxlength="100" autocomplete="off">
            <select class="filter-select" id="content-subject-filter" onchange="filterContent()">
                <option value="">Topics</option>
                <option value="Sequences and Series">Sequences and Series</option>
                <option value="Polynomials and Polynomial Equations">Polynomials and Polynomial Equations</option>
                <option value="Advanced Equations and Functions">Advanced Equations and Functions</option>
            </select>
            <button class="add-btn" onclick="openAddContent()">+ Add Module</button>
        </div>

        <div class="content-grid" id="content-grid">
            </div>
    </div>
</div>

<div id="addContentModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; backdrop-filter: blur(5px);">
    <div class="modal-content" style="background:white; padding:2rem; border-radius:15px; width:90%; max-width:450px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2 style="font-size:20px; font-weight:700; color:#1a202c;">Add New Module</h2>
            <button onclick="closeAddContent()" style="background:none; border:none; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        
        <form id="uploadModuleForm" onsubmit="handleUpload(event)">
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Module Title</label>
                <input type="text" id="moduleTitle" class="search-input" style="width:100%; border:1px solid #e2e8f0; padding:10px; border-radius:8px;" placeholder="e.g. Introduction to Algebra" required>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Subject</label>
                <select id="moduleSubject" class="filter-select" style="width:100%; border:1px solid #e2e8f0; padding:10px; border-radius:8px;" required>
                    <option value="Sequences and Series">Sequences and Series</option>
                <option value="Polynomials and Polynomial Equations">Polynomials and Polynomial Equations</option>
                <option value="Advanced Equations and Functions">Advanced Equations and Functions</option>
                </select>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Description</label>
                <textarea id="moduleDescription" class="search-input" style="width:100%; height:80px; border:1px solid #e2e8f0; padding:10px; border-radius:8px;" placeholder="Brief description of this module..."></textarea>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Upload Module File</label>
                <div style="border: 2px dashed #cbd5e0; padding: 15px; border-radius: 10px; text-align: center; background: #f8fafc;">
                    <input type="file" id="moduleFile" style="width:100%; cursor:pointer;" required>
                    <small style="display:block; color:#718096; margin-top:5px;">Accepted: PDF, DOCX, MP4, or Images</small>
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:5px; text-transform:uppercase;">Status</label>
                <select id="moduleStatus" class="filter-select" style="width:100%; border:1px solid #e2e8f0; padding:10px; border-radius:8px;">
                    <option value="Published">Published</option>
                    <option value="Draft">Draft</option>
                </select>
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="tbl-btn edit" onclick="closeAddContent()" style="background:#edf2f7; color:#4a5568; padding: 10px 20px; border-radius:8px; border:none; cursor:pointer;">Cancel</button>
                <button type="submit" class="add-btn" style="width:auto; padding:0 25px; border-radius:8px;">Save Module</button>
            </div>
        </form>
    </div>
</div>
            <!-- ACTIVITY PAGE -->
            <div class="page" id="page-activity">
                <div class="hero-section">
                    <h1 class="welcome-title">Activity Tracking</h1>
                    <p class="welcome-subtitle">Full log of user actions and system events</p>
                </div>
                <div class="metrics-scroll-wrap">
                    <div class="metrics-grid">
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Events Today</span><div class="icon-container blue-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div></div><div class="metric-value" id="ac-events">0</div><div class="metric-sub">since midnight</div></div>
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Logins Today</span><div class="icon-container green-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg></div></div><div class="metric-value" id="ac-logins">0</div><div class="metric-sub">sessions started</div></div>
                        <div class="metric-card"><div class="metric-header"><span class="metric-label">Errors</span><div class="icon-container red-theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div></div><div class="metric-value" id="ac-errors">0</div><div class="metric-sub">system warnings</div></div>
                    </div>
                </div>
                <div class="modules-container">
                    <div class="section-label">Event Timeline</div>
                    <div class="section-sub">Most recent system and user events</div>
                    <div class="toolbar">
                        <select class="filter-select" id="activity-filter" onchange="filterActivity()" style="flex:1">
                            <option value="">All Events</option>
                            <option value="registration">Registrations</option>
                            <option value="login">Logins</option>
                            <option value="content">Content</option>
                            <option value="system">System</option>
                            <option value="error">Errors</option>
                        </select>
                    </div>
                    <div class="activity-timeline" id="activity-timeline">
                        <div class="empty-state">
                            <div class="empty-icon">📋</div>
                            <h4>No events logged yet</h4>
                            <p>Activity will appear here as users interact with the platform.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SETTINGS PAGE -->
            <div class="page" id="page-settings">
                <div class="hero-section">
                    <h1 class="welcome-title">System Settings</h1>
                    <p class="welcome-subtitle">Configure platform preferences, roles, and features</p>
                </div>
                <div class="settings-section">
                    <h3>Platform Info</h3>
                    <div class="desc">Basic information about your Math Learning platform</div>
                    <div class="field-row"><label>Platform Name</label><input type="text" id="s-platform-name" placeholder="Math Learning Assistant" maxlength="80" autocomplete="off"></div>
                    <div class="field-row"><label>Admin Email</label><input type="email" id="s-admin-email" placeholder="admin@mathlearn.edu" maxlength="120" autocomplete="off"></div>
                    <div class="field-row"><label>Platform Description</label><textarea id="s-desc" rows="3" placeholder="Describe your platform…" maxlength="500"></textarea></div>
                    <div class="save-row">
                        <button class="btn-cancel">Cancel</button>
                        <button class="btn-save" onclick="savePlatformInfo()">Save Changes</button>
                    </div>
                </div>
                <div class="settings-section">
                    <h3>Notifications</h3>
                    <div class="desc">Choose what notifications the system sends</div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">New User Registrations</div><div class="toggle-sub">Notify admin when a new user joins</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">Content Published</div><div class="toggle-sub">Alert when teacher publishes a module</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">System Errors</div><div class="toggle-sub">Immediate alert on critical errors</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">Weekly Report</div><div class="toggle-sub">Receive a weekly usage digest</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="save-row"><button class="btn-cancel">Cancel</button><button class="btn-save" onclick="saveSettings('Notification')">Save Preferences</button></div>
                </div>
                <div class="settings-section">
                    <h3>Roles &amp; Permissions</h3>
                    <div class="desc">Configure what each role can access and modify</div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Permission</th><th>Admin</th><th>Teacher</th><th>Student</th></tr></thead>
                            <tbody>
                                <tr><td>View Dashboard</td><td>✅</td><td>✅</td><td>✅</td></tr>
                                <tr><td>Manage Users</td><td>✅</td><td>❌</td><td>❌</td></tr>
                                <tr><td>Create Content</td><td>✅</td><td>✅</td><td>❌</td></tr>
                                <tr><td>View Analytics</td><td>✅</td><td>✅</td><td>❌</td></tr>
                                <tr><td>System Settings</td><td>✅</td><td>❌</td><td>❌</td></tr>
                                <tr><td>Take Quizzes</td><td>✅</td><td>✅</td><td>✅</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="save-row"><button class="btn-save" onclick="saveSettings('Roles & Permissions')">Save Roles</button></div>
                </div>
                <div class="settings-section">
                    <h3>Feature Flags</h3>
                    <div class="desc">Enable or disable platform features</div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">AI Tutor Mode</div><div class="toggle-sub">Enable AI-powered tutoring assistance</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">Student Leaderboard</div><div class="toggle-sub">Show ranking among students</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">Maintenance Mode</div><div class="toggle-sub">Temporarily disable access for non-admins</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="toggle-row"><div class="toggle-info"><div class="toggle-title">Registration Open</div><div class="toggle-sub">Allow new users to register</div></div><label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                    <div class="save-row"><button class="btn-cancel">Cancel</button><button class="btn-save" onclick="saveSettings('Feature Flags')">Save Features</button></div>
                </div>
                <div class="settings-section" style="border-color:#fca5a5">
                    <h3 style="color:var(--red)">Danger Zone</h3>
                    <div class="desc">Irreversible actions — proceed with caution</div>
                    <div style="display:flex;gap:10px;flex-wrap:wrap">
                        <button class="danger-btn" style="max-width:200px" onclick="confirmDanger('Clear All Logs','This will permanently delete all system activity logs.')">Clear All Logs</button>
                        <button class="danger-btn" style="max-width:200px" onclick="confirmDanger('Reset Platform','This will reset all settings to factory defaults.')">Reset Platform</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
    <button class="nav-item active" data-page="home"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><span>Home</span><div class="nav-dot"></div></button>
    <button class="nav-item" data-page="users"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Users</span><div class="nav-dot"></div></button>
    <button class="nav-item" data-page="analytics"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg><span>Analytics</span><div class="nav-dot"></div></button>
    <button class="nav-item" data-page="content"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span>Content</span><div class="nav-dot"></div></button>
    <button class="nav-item" data-page="settings"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg><span>Settings</span><div class="nav-dot"></div></button>
</nav>

<!-- ADD USER MODAL -->
<div class="modal-overlay" id="modal-user">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title" id="modal-user-title">Add New User</span>
            <button class="modal-close" onclick="closeModal('modal-user')">✕</button>
        </div>
        <div class="field-row"><label>Full Name</label><input type="text" id="u-name" placeholder="e.g. Juan dela Cruz" maxlength="80" autocomplete="off"></div>
        <div class="field-row"><label>Email</label><input type="email" id="u-email" placeholder="user@example.com" maxlength="120" autocomplete="off"></div>
        <div class="field-row"><label>Role</label>
            <select id="u-role"><option value="student">Student</option><option value="teacher">Teacher</option><option value="admin">Admin</option></select>
        </div>
        <div class="field-row"><label>Status</label>
            <select id="u-status"><option value="Active">Active</option><option value="Inactive">Inactive</option></select>
        </div>
        <div class="save-row">
            <button class="btn-cancel" onclick="closeModal('modal-user')">Cancel</button>
            <button class="btn-save" onclick="saveUser()">Save User</button>
        </div>
    </div>
</div>

<!-- ADD CONTENT MODAL -->
<div class="modal-overlay" id="modal-content">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title" id="modal-content-title">Add New Module</span>
            <button class="modal-close" onclick="closeModal('modal-content')">✕</button>
        </div>
        <div class="field-row"><label>Module Title</label><input type="text" id="c-title" placeholder="e.g. Introduction to Algebra" maxlength="120" autocomplete="off"></div>
        <div class="field-row"><label>Subject</label>
            <select id="c-subject"><option>Sequences and Series</option><option>Polynomials and Polynomial Equations</option><option>Advanced Equations and Functions</option><option>Statistics</option></select>
        </div>
        <div class="field-row"><label>Description</label><textarea id="c-desc" rows="3" placeholder="Brief description of this module…" maxlength="500"></textarea></div>
        <div class="field-row"><label>Status</label>
            <select id="c-status"><option value="Published">Published</option><option value="Draft">Draft</option></select>
        </div>
        <div class="save-row">
            <button class="btn-cancel" onclick="closeModal('modal-content')">Cancel</button>
            <button class="btn-save" onclick="saveContent()">Save Module</button>
        </div>
    </div>
</div>
<script>
    function approveUser(userId) {
        if (confirm('Are you sure you want to approve this user?')) {
            fetch(`/admin/users/${userId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Ito ang sasalo kung may SQL error (tulad ng Truncated data)
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                // Binago natin mula data.success papuntang data.message
                alert(data.message || 'User approved successfully!');
                location.reload(); 
            })
            .catch(error => {
                console.error('Error:', error);
                // I-alert ang mismong error message mula sa server
                alert('Error: ' + (error.message || 'Something went wrong'));
            });
        }
    }
</script>

<script>
    window.laravelUsers = @json($allUsers);
</script>

<script src="{{ asset('js/dashboard/admin_dashboard.js') }}"></script>
</body>
</html>