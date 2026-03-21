/* ============================================================
   admin_dashboard.js
   Math Learning Assistant – Admin Dashboard
   ============================================================ */

'use strict';

// ============================================================
//  DATA
// ============================================================

let users = [
    { id: 1,  name: 'Kristine Villamor', email: 'kristine@school.ph',   role: 'student', status: 'Active',   joined: 'Mar 19, 2026' },
    { id: 2,  name: 'Mark Reyes',        email: 'mark.reyes@school.ph',  role: 'student', status: 'Active',   joined: 'Mar 18, 2026' },
    { id: 3,  name: 'Dr. Ana Santos',    email: 'ana.santos@school.ph',  role: 'teacher', status: 'Active',   joined: 'Jan 10, 2026' },
    { id: 4,  name: 'Prof. Jose Lim',    email: 'jose.lim@school.ph',    role: 'teacher', status: 'Active',   joined: 'Jan  5, 2026' },
    { id: 5,  name: 'Maria Cruz',        email: 'maria.cruz@school.ph',  role: 'student', status: 'Inactive', joined: 'Feb 14, 2026' },
    { id: 6,  name: 'Admin User',        email: 'admin@mathlearn.edu',   role: 'admin',   status: 'Active',   joined: 'Dec  1, 2025' },
    { id: 7,  name: 'Carlo Mendoza',     email: 'carlo@school.ph',       role: 'student', status: 'Active',   joined: 'Mar 15, 2026' },
    { id: 8,  name: 'Sofia Garcia',      email: 'sofia@school.ph',       role: 'student', status: 'Active',   joined: 'Mar 12, 2026' },
    { id: 9,  name: 'Rico Bautista',     email: 'rico@school.ph',        role: 'teacher', status: 'Active',   joined: 'Feb  1, 2026' },
    { id: 10, name: 'Lea Torres',        email: 'lea@school.ph',         role: 'student', status: 'Active',   joined: 'Mar 10, 2026' },
    { id: 11, name: 'Noel Aquino',       email: 'noel@school.ph',        role: 'student', status: 'Inactive', joined: 'Feb 28, 2026' },
    { id: 12, name: 'Patricia Sy',       email: 'patricia@school.ph',    role: 'student', status: 'Active',   joined: 'Mar  8, 2026' },
];

let contents = [
    { id: 1, title: 'Introduction to Algebra',  subject: 'Algebra',    desc: 'Basic algebraic expressions and equations.',          status: 'Published', lessons: 12, emoji: '➕' },
    { id: 2, title: 'Quadratic Equations',       subject: 'Algebra',    desc: 'Solving quadratic equations by factoring and formula.',status: 'Published', lessons: 8,  emoji: '📐' },
    { id: 3, title: 'Triangles & Congruence',    subject: 'Geometry',   desc: 'Properties of triangles and congruence theorems.',     status: 'Published', lessons: 10, emoji: '📏' },
    { id: 4, title: 'Limits & Continuity',       subject: 'Calculus',   desc: 'Introduction to limits and continuity of functions.',  status: 'Draft',     lessons: 6,  emoji: '∞'  },
    { id: 5, title: 'Descriptive Statistics',    subject: 'Statistics', desc: 'Mean, median, mode, and standard deviation.',         status: 'Published', lessons: 9,  emoji: '📊' },
    { id: 6, title: 'Coordinate Geometry',       subject: 'Geometry',   desc: 'Plotting points, lines, and curves in 2D.',           status: 'Draft',     lessons: 7,  emoji: '📍' },
];

const activityData = [
    { type: 'registration', color: 'blue',   title: 'Kristine Villamor registered',    sub: 'New student account created',                    time: '2 hours ago'  },
    { type: 'content',      color: 'green',  title: 'Dr. Ana Santos published a module', sub: 'Quadratic Equations added to Algebra',          time: '4 hours ago'  },
    { type: 'system',       color: 'orange', title: 'System updated to v2.4.1',         sub: 'Automated patch applied successfully',            time: '5 hours ago'  },
    { type: 'login',        color: 'blue',   title: 'Prof. Jose Lim logged in',          sub: 'Session started from Manila, PH',                time: '6 hours ago'  },
    { type: 'login',        color: 'blue',   title: 'Admin logged in',                   sub: 'Dashboard accessed',                             time: '7 hours ago'  },
    { type: 'content',      color: 'green',  title: 'New quiz created',                  sub: 'Statistics Module — Chapter 3 Quiz',             time: '9 hours ago'  },
    { type: 'registration', color: 'blue',   title: 'Carlo Mendoza registered',          sub: 'New student account created',                    time: '1 day ago'    },
    { type: 'error',        color: 'red',    title: 'Failed login attempt',              sub: 'Unknown IP: 202.93.14.5 — blocked',              time: '1 day ago'    },
    { type: 'system',       color: 'orange', title: 'Database backup completed',         sub: 'Full backup saved to cloud storage',             time: '2 days ago'   },
    { type: 'error',        color: 'red',    title: 'Module upload error',               sub: 'File too large — rejected (limit: 50 MB)',       time: '2 days ago'   },
    { type: 'login',        color: 'blue',   title: 'Sofia Garcia logged in',            sub: 'Mobile session',                                 time: '2 days ago'   },
    { type: 'content',      color: 'green',  title: 'Module archived',                   sub: 'Old Trigonometry draft removed',                 time: '3 days ago'   },
];

// State
let userEditId    = null;
let contentEditId = null;
const USERS_PER_PAGE = 6;
let userPage = 1;

// ============================================================
//  NAVIGATION
// ============================================================

function navigate(page) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sidebar-item').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));

    document.getElementById('page-' + page).classList.add('active');
    document.querySelectorAll('[data-page="' + page + '"]').forEach(b => b.classList.add('active'));
    window.scrollTo(0, 0);

    if (page === 'users')     renderUsers();
    if (page === 'analytics') renderAnalytics();
    if (page === 'content')   renderContent();
    if (page === 'activity')  renderActivity();
}

// ============================================================
//  USERS
// ============================================================

function getFilteredUsers() {
    const q    = (document.getElementById('user-search')?.value || '').toLowerCase();
    const role = document.getElementById('user-role-filter')?.value || '';
    return users.filter(u =>
        (u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)) &&
        (!role || u.role === role)
    );
}

function renderUsers() {
    const filtered   = getFilteredUsers();
    const totalPages = Math.max(1, Math.ceil(filtered.length / USERS_PER_PAGE));
    if (userPage > totalPages) userPage = totalPages;
    const slice = filtered.slice((userPage - 1) * USERS_PER_PAGE, userPage * USERS_PER_PAGE);

    const tbody = document.getElementById('users-tbody');

    if (!slice.length) {
        tbody.innerHTML = `
            <tr><td colspan="7">
                <div class="empty-state">
                    <div class="empty-icon">👤</div>
                    <h4>No users found</h4>
                    <p>Try a different search or filter.</p>
                </div>
            </td></tr>`;
    } else {
        tbody.innerHTML = slice.map((u, i) => `
            <tr>
                <td style="color:var(--text-4);font-size:12px">${(userPage - 1) * USERS_PER_PAGE + i + 1}</td>
                <td><b>${u.name}</b></td>
                <td style="color:var(--text-3)">${u.email}</td>
                <td><span class="role-badge role-${u.role}">${capitalize(u.role)}</span></td>
                <td style="font-size:12px;color:var(--text-3)">${u.joined}</td>
                <td><span class="status-badge ${u.status === 'Active' ? 'badge-good' : 'badge-danger'}">${u.status}</span></td>
                <td>
                    <button class="tbl-btn edit" onclick="editUser(${u.id})">Edit</button>
                    <button class="tbl-btn del"  onclick="deleteUser(${u.id})">Delete</button>
                </td>
            </tr>`).join('');
    }

    // Pagination
    const pg = document.getElementById('user-pagination');
    pg.innerHTML = '';

    const prev = makePgBtn('‹ Prev', userPage === 1, () => { userPage--; renderUsers(); });
    pg.appendChild(prev);

    for (let i = 1; i <= totalPages; i++) {
        const btn = makePgBtn(i, false, () => { userPage = i; renderUsers(); });
        if (i === userPage) btn.classList.add('active');
        pg.appendChild(btn);
    }

    const next = makePgBtn('Next ›', userPage === totalPages, () => { userPage++; renderUsers(); });
    pg.appendChild(next);
}

function filterUsers() { userPage = 1; renderUsers(); }

function openAddUser() {
    userEditId = null;
    document.getElementById('modal-user-title').textContent = 'Add New User';
    document.getElementById('u-name').value   = '';
    document.getElementById('u-email').value  = '';
    document.getElementById('u-role').value   = 'student';
    document.getElementById('u-status').value = 'Active';
    openModal('modal-user');
}

function editUser(id) {
    const u = users.find(x => x.id === id);
    if (!u) return;
    userEditId = id;
    document.getElementById('modal-user-title').textContent = 'Edit User';
    document.getElementById('u-name').value   = u.name;
    document.getElementById('u-email').value  = u.email;
    document.getElementById('u-role').value   = u.role;
    document.getElementById('u-status').value = u.status;
    openModal('modal-user');
}

function saveUser() {
    const name   = document.getElementById('u-name').value.trim();
    const email  = document.getElementById('u-email').value.trim();
    const role   = document.getElementById('u-role').value;
    const status = document.getElementById('u-status').value;

    if (!name || !email) {
        Swal.fire({ icon: 'warning', title: 'Missing fields', text: 'Please fill in all required fields.', confirmButtonColor: '#2563eb' });
        return;
    }

    if (userEditId) {
        const u = users.find(x => x.id === userEditId);
        Object.assign(u, { name, email, role, status });
    } else {
        users.push({
            id: Date.now(), name, email, role, status,
            joined: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
        });
        updateHomeMetrics();
    }

    closeModal('modal-user');
    renderUsers();
    toast('success', userEditId ? 'User updated successfully.' : 'New user added successfully.');
}

function deleteUser(id) {
    Swal.fire({
        title: 'Delete User?', text: 'This action cannot be undone.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Yes, delete',
    }).then(r => {
        if (r.isConfirmed) {
            users = users.filter(u => u.id !== id);
            renderUsers();
            updateHomeMetrics();
            toast('success', 'User deleted.');
        }
    });
}

// ============================================================
//  ANALYTICS
// ============================================================

function renderAnalytics() {
    // Bar chart – weekly registrations
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    const vals = [8, 14, 6, 18, 12, 9, 5];
    const maxV = Math.max(...vals);
    document.getElementById('reg-chart').innerHTML = days.map((d, i) => `
        <div class="bar-group">
            <div class="bar-val">${vals[i]}</div>
            <div class="bar"
                 style="height:${Math.round((vals[i] / maxV) * 120)}px;
                        background:linear-gradient(180deg,#60a5fa,#2563eb)"
                 title="${vals[i]} registrations"></div>
            <div class="bar-label">${d}</div>
        </div>`).join('');

    // Subject completion progress bars
    const subjects = [
        { name: 'Algebra',    pct: 82, color: '#2563eb' },
        { name: 'Geometry',   pct: 67, color: '#10b981' },
        { name: 'Calculus',   pct: 45, color: '#f97316' },
        { name: 'Statistics', pct: 74, color: '#a855f7' },
    ];
    document.getElementById('subject-progress').innerHTML = subjects.map(s => `
        <div class="progress-row">
            <div class="progress-label"><span>${s.name}</span><span>${s.pct}%</span></div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:${s.pct}%;background:${s.color}"></div>
            </div>
        </div>`).join('');

    // Distribution
    const dist = [
        { label: 'Students', pct: '74%', count: 184, color: '#2563eb', bg: '#eff6ff' },
        { label: 'Teachers', pct: '7%',  count: 18,  color: '#10b981', bg: '#f0fdf4' },
        { label: 'Admins',   pct: '3%',  count: 8,   color: '#f97316', bg: '#fff7ed' },
        { label: 'Inactive', pct: '16%', count: 38,  color: '#a855f7', bg: '#faf5ff' },
    ];
    document.getElementById('donut-row').innerHTML = dist.map(d => `
        <div class="donut-item">
            <div class="donut-circle" style="background:${d.bg};color:${d.color}">${d.pct}</div>
            <div class="donut-info">
                <div class="donut-pct">${d.count}</div>
                <div class="donut-lbl">${d.label}</div>
            </div>
        </div>`).join('');

    // Top students
    const tops = [
        { name: 'Sofia Garcia',  score: '96%', modules: 18, streak: '14 days' },
        { name: 'Carlo Mendoza', score: '92%', modules: 16, streak: '9 days'  },
        { name: 'Lea Torres',    score: '89%', modules: 14, streak: '7 days'  },
        { name: 'Patricia Sy',   score: '87%', modules: 13, streak: '5 days'  },
        { name: 'Mark Reyes',    score: '84%', modules: 12, streak: '3 days'  },
    ];
    document.getElementById('top-students-tbody').innerHTML = tops.map((s, i) => `
        <tr>
            <td>${['🥇','🥈','🥉','4️⃣','5️⃣'][i]}</td>
            <td><b>${s.name}</b></td>
            <td style="color:var(--green);font-weight:700">${s.score}</td>
            <td>${s.modules}</td>
            <td>${s.streak}</td>
        </tr>`).join('');
}

// ============================================================
//  CONTENT
// ============================================================

const SUBJECT_EMOJIS = { Algebra: '➕', Geometry: '📐', Calculus: '∞', Statistics: '📊' };

function getFilteredContent() {
    const q    = (document.getElementById('content-search')?.value || '').toLowerCase();
    const subj = document.getElementById('content-subject-filter')?.value || '';
    return contents.filter(c =>
        (c.title.toLowerCase().includes(q) || c.subject.toLowerCase().includes(q)) &&
        (!subj || c.subject === subj)
    );
}

function renderContent() {
    const grid     = document.getElementById('content-grid');
    const filtered = getFilteredContent();

    if (!filtered.length) {
        grid.innerHTML = `
            <div class="empty-state" style="grid-column:1/-1">
                <div class="empty-icon">📚</div>
                <h4>No modules found</h4>
                <p>Try a different search.</p>
            </div>`;
        return;
    }

    grid.innerHTML = filtered.map(c => `
        <div class="content-card">
            <div class="content-thumb"
                 style="background:${c.status === 'Published' ? '#f0fdf4' : '#fff7ed'}">${c.emoji}</div>
            <div class="content-body">
                <div class="content-title">${c.title}</div>
                <div class="content-meta">
                    ${c.subject} &bull; ${c.lessons} lessons &bull;
                    <span class="status-badge ${c.status === 'Published' ? 'badge-good' : 'badge-system'}">${c.status}</span>
                </div>
                <div style="font-size:12px;color:var(--text-3);margin-bottom:10px;line-height:1.4">${c.desc}</div>
                <div class="content-actions">
                    <button class="tbl-btn edit" style="flex:1" onclick="editContent(${c.id})">Edit</button>
                    <button class="tbl-btn del"  style="flex:1" onclick="deleteContent(${c.id})">Delete</button>
                </div>
            </div>
        </div>`).join('');
}

function filterContent() { renderContent(); }

function openAddContent() {
    contentEditId = null;
    document.getElementById('modal-content-title').textContent = 'Add New Module';
    document.getElementById('c-title').value   = '';
    document.getElementById('c-subject').value = 'Algebra';
    document.getElementById('c-desc').value    = '';
    document.getElementById('c-status').value  = 'Published';
    openModal('modal-content');
}

function editContent(id) {
    const c = contents.find(x => x.id === id);
    if (!c) return;
    contentEditId = id;
    document.getElementById('modal-content-title').textContent = 'Edit Module';
    document.getElementById('c-title').value   = c.title;
    document.getElementById('c-subject').value = c.subject;
    document.getElementById('c-desc').value    = c.desc;
    document.getElementById('c-status').value  = c.status;
    openModal('modal-content');
}

function saveContent() {
    const title   = document.getElementById('c-title').value.trim();
    const subject = document.getElementById('c-subject').value;
    const desc    = document.getElementById('c-desc').value.trim();
    const status  = document.getElementById('c-status').value;

    if (!title) {
        Swal.fire({ icon: 'warning', title: 'Missing title', text: 'Please enter a module title.', confirmButtonColor: '#2563eb' });
        return;
    }

    if (contentEditId) {
        const c = contents.find(x => x.id === contentEditId);
        Object.assign(c, { title, subject, desc: desc || c.desc, status, emoji: SUBJECT_EMOJIS[subject] || '📚' });
    } else {
        contents.push({
            id: Date.now(), title, subject,
            desc: desc || 'No description.', status, lessons: 0,
            emoji: SUBJECT_EMOJIS[subject] || '📚',
        });
    }

    closeModal('modal-content');
    renderContent();
    toast('success', 'Module saved successfully.');
}

function deleteContent(id) {
    Swal.fire({
        title: 'Delete Module?', text: 'This cannot be undone.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Yes, delete',
    }).then(r => {
        if (r.isConfirmed) {
            contents = contents.filter(c => c.id !== id);
            renderContent();
            toast('success', 'Module deleted.');
        }
    });
}

// ============================================================
//  ACTIVITY
// ============================================================

function renderActivity() {
    const filter   = document.getElementById('activity-filter')?.value || '';
    const filtered = filter ? activityData.filter(a => a.type === filter) : activityData;
    const tl       = document.getElementById('activity-timeline');

    if (!filtered.length) {
        tl.innerHTML = `<div class="empty-state"><div class="empty-icon">📋</div><h4>No events found</h4></div>`;
        return;
    }

    tl.innerHTML = filtered.map(a => `
        <div class="tl-item">
            <div class="tl-dot ${a.color}"></div>
            <div class="tl-title">${a.title}</div>
            <div class="tl-sub">${a.sub}</div>
            <div class="tl-time">${a.time}</div>
        </div>`).join('');
}

function filterActivity() { renderActivity(); }

// ============================================================
//  SETTINGS
// ============================================================

function savePlatformInfo() {
    const name = document.getElementById('s-platform-name').value.trim();
    if (!name) {
        Swal.fire({ icon: 'warning', title: 'Platform name required', confirmButtonColor: '#2563eb' });
        return;
    }
    toast('success', 'Platform info saved!');
}

function saveSettings(label) {
    toast('success', `${label} saved!`);
}

function confirmDanger(action, desc) {
    Swal.fire({
        title: `${action}?`, text: desc,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db',
        confirmButtonText: `Yes, ${action}`,
    }).then(r => {
        if (r.isConfirmed) toast('success', `${action} complete.`);
    });
}

// ============================================================
//  MODAL HELPERS
// ============================================================

function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// ============================================================
//  LOGOUT
// ============================================================

function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out of your account.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel',
    }).then(r => {
        if (r.isConfirmed) {
            // Swap the line below for: document.getElementById('logout-form').submit();
            Swal.fire({ icon: 'success', title: 'Logged out', text: 'Goodbye!', timer: 1500, timerProgressBar: true, showConfirmButton: false });
        }
    });
}

// ============================================================
//  UTILITIES
// ============================================================

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function toast(icon, title) {
    Swal.fire({ icon, title, timer: 2000, timerProgressBar: true, showConfirmButton: false });
}

function makePgBtn(label, disabled, handler) {
    const btn = document.createElement('button');
    btn.className    = 'pg-btn';
    btn.textContent  = label;
    btn.disabled     = disabled;
    btn.addEventListener('click', handler);
    return btn;
}

function updateHomeMetrics() {
    const totalEl    = document.getElementById('m-total');
    const studentEl  = document.getElementById('m-students');
    const teacherEl  = document.getElementById('m-teachers');
    if (totalEl)   totalEl.textContent   = users.length;
    if (studentEl) studentEl.textContent = users.filter(u => u.role === 'student').length;
    if (teacherEl) teacherEl.textContent = users.filter(u => u.role === 'teacher').length;
}

// ============================================================
//  EXPOSE FUNCTIONS TO GLOBAL SCOPE
//  (required because 'use strict' + inline onclick handlers
//   need functions accessible on window)
// ============================================================

window.navigate        = navigate;
window.filterUsers     = filterUsers;
window.openAddUser     = openAddUser;
window.editUser        = editUser;
window.saveUser        = saveUser;
window.deleteUser      = deleteUser;
window.filterContent   = filterContent;
window.openAddContent  = openAddContent;
window.editContent     = editContent;
window.saveContent     = saveContent;
window.deleteContent   = deleteContent;
window.filterActivity  = filterActivity;
window.savePlatformInfo= savePlatformInfo;
window.saveSettings    = saveSettings;
window.confirmDanger   = confirmDanger;
window.openModal       = openModal;
window.closeModal      = closeModal;
window.confirmLogout   = confirmLogout;

// ============================================================
//  INIT
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // Navigation – sidebar items & bottom nav
    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', function () {
            navigate(this.dataset.page);
        });
    });

    // Close modals by clicking overlay backdrop
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function (e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // Logout buttons
    ['logout-btn-mobile', 'logout-btn-desktop'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', confirmLogout);
    });

    // Seed initial render
    renderUsers();
});