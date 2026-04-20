/**
 * admin_dashboard.js
 * Path: resources/js/dashboard/admin_dashboard.js
 *
 * Install deps:   npm install sweetalert2
 * Dev server:     npm run dev
 * Production:     npm run build
 */

import Swal from 'sweetalert2';
// SweetAlert2 CSS is loaded via CDN link in the blade file

'use strict';

/* ============================================================
   SECURITY — XSS Prevention
   All user-supplied data must pass through Security.escape()
   before being inserted into the DOM via innerHTML.
   ============================================================ */
const Security = {
    /** Escapes the 7 key HTML special characters */
    escape(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g,  '&amp;')
            .replace(/</g,  '&lt;')
            .replace(/>/g,  '&gt;')
            .replace(/"/g,  '&quot;')
            .replace(/'/g,  '&#x27;')
            .replace(/\//g, '&#x2F;')
            .replace(/`/g,  '&#x60;');
    },
    /** Strip angle brackets & quotes from plain text inputs */
    sanitize(str) {
        if (str == null) return '';
        return String(str).replace(/[<>"'`]/g, '').trim();
    },
    isValidEmail(e)  { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(e); },
    isValidRole(r)   { return ['admin','teacher','student'].includes(r); },
    isValidStatus(s) { return ['Active','Inactive'].includes(s); },
    isValidModStatus(s) { return ['Published','Draft'].includes(s); },
    isValidSubject(s)   { return ['Algebra','Geometry','Calculus','Statistics'].includes(s); },
};

/* ============================================================
   STATE — starts completely empty
   ============================================================ */
let users = window.laravelUsers || [];
let contents = [];
let activity = [];

let userEditId    = null;
let contentEditId = null;
const USERS_PER_PAGE = 6;
let userPage = 1;
// Kukunin ang data mula sa storage, kung wala, empty array []
let learningModules = JSON.parse(localStorage.getItem('my_learning_modules')) || [];
/* ============================================================
    MODULE MANAGEMENT (UPLOAD & RENDER)
   ============================================================ */

/** 1. Buksan ang Upload Modal */
window.openAddContent = function() {
    const modal = document.getElementById('addContentModal');
    if (modal) modal.style.display = 'flex';
};

/** 2. Isara ang Upload Modal */
window.closeAddContent = function() {
    const modal = document.getElementById('addContentModal');
    if (modal) {
        modal.style.display = 'none';
        document.getElementById('uploadModuleForm').reset();
    }
};

/** 3. Handle the Upload Form Submission */
// Function para sa handleUpload
window.handleUpload = function(event) {
    event.preventDefault();
    
    const title = document.getElementById('moduleTitle').value;
    const subject = document.getElementById('moduleSubject').value;
    const description = document.getElementById('moduleDescription').value;
    const status = document.getElementById('moduleStatus').value;
    const fileInput = document.getElementById('moduleFile');

    if (!fileInput.files[0]) {
        return Swal.fire('Error', 'Please select a file to upload.', 'error');
    }

    const newModule = {
        id: Date.now(),
        title: Security.escape(title),
        subject: subject,
        description: Security.escape(description),
        status: status,
        fileName: Security.escape(fileInput.files[0].name), // Kinukuha ang name ng in-upload
        date: new Date().toLocaleDateString()
    };

    // Save to State & LocalStorage
    learningModules.push(newModule);
    localStorage.setItem('my_learning_modules', JSON.stringify(learningModules));

    // UI Updates
    closeAddContent();
    renderModules();

    Swal.fire('Success', 'Module uploaded successfully!', 'success');
};

// Function para sa renderModules
window.renderModules = function() {
    const grid = document.getElementById('content-grid');
    if (!grid) return;

    if (learningModules.length === 0) {
        grid.innerHTML = `
            <div class="empty-state" style="grid-column:1/-1">
                <div class="empty-icon">📚</div>
                <h4>No modules yet</h4>
                <p>Click "+ Add Module" to create your first learning module.</p>
            </div>`;
        return;
    }

    grid.innerHTML = learningModules.map(m => `
        <div class="module-card" style="background:white; padding:1.5rem; border-radius:12px; border-left:5px solid #3b82f6; box-shadow:0 4px 6px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:start;">
                <span class="role-badge role-teacher">${Security.escape(m.subject)}</span>
                <span style="font-size:11px; color:#999">${m.status}</span>
            </div>
            <h3 style="margin:10px 0 5px 0; font-size:16px;">${Security.escape(m.title)}</h3>
            <p style="font-size:12px; color:#666; margin-bottom:5px;">📄 ${Security.escape(m.fileName)}</p>
            <p style="font-size:11px; color:#a0aec0; font-style:italic;">${Security.escape(m.description)}</p>
            <div style="margin-top:15px; display:flex; gap:8px;">
                <button class="tbl-btn edit" style="flex:1">Open File</button>
                <button class="tbl-btn del" onclick="deleteModule(${m.id})">Delete</button>
            </div>
        </div>
    `).join('');
};
/** 5. Burahin ang Module */
window.deleteModule = function(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Mabubura ang module na ito sa listahan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            learningModules = learningModules.filter(m => m.id !== id);
            localStorage.setItem('my_learning_modules', JSON.stringify(learningModules));
            renderModules();
            Swal.fire('Deleted!', 'Ang module ay nabura na.', 'success');
        }
    });
};

/* ============================================================
    INITIALIZATION
   ============================================================ */

document.addEventListener('DOMContentLoaded', function() {
    // Tawagin ang render functions pag-load ng page
    if (typeof renderUsers === 'function') renderUsers();
    renderModules();
});
/* ============================================================
   NAVIGATION
   ============================================================ */
function navigate(page) {
    const allowed = ['home','users','analytics','content','activity','settings'];
    if (!allowed.includes(page)) return;

    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sidebar-item').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));

    document.getElementById('page-' + page).classList.add('active');
    document.querySelectorAll('[data-page="' + page + '"]').forEach(b => b.classList.add('active'));
    window.scrollTo(0, 0);

    if (page === 'home')     renderHome();
    if (page === 'users')    renderUsers();
    if (page === 'analytics') renderAnalytics();
    if (page === 'content')  renderContent();
    if (page === 'activity') renderActivity();
}

/* ============================================================
   HOME
   ============================================================ */
function renderHome() {
    setText('m-total',    users.length);
    setText('m-students', users.filter(u => u.role === 'student').length);
    setText('m-teachers', users.filter(u => u.role === 'teacher').length);

    const logEl = document.getElementById('home-activity-log');
    if (!activity.length) {
        logEl.innerHTML = '<div class="empty-state"><div class="empty-icon">📋</div><h4>No activity yet</h4><p>Events will appear here as users interact with the platform.</p></div>';
        return;
    }
    const colors = { registration:'blue-avatar', login:'green-avatar', content:'purple-avatar', system:'orange-avatar', error:'red-avatar' };
    logEl.innerHTML = activity.slice(0, 3).map(a => `
        <div class="log-item">
            <div class="log-info">
                <div class="log-avatar ${colors[a.type] || 'blue-avatar'}">${Security.escape(initials(a.title))}</div>
                <div>
                    <div class="log-title">${Security.escape(a.title)}</div>
                    <div class="log-meta">${Security.escape(a.sub)}</div>
                </div>
            </div>
            <span class="status-badge badge-new">${Security.escape(a.badge)}</span>
        </div>`).join('');
}

/* ============================================================
   USERS
   ============================================================ */
function getFilteredUsers() {
    const q    = Security.sanitize(document.getElementById('user-search')?.value || '').toLowerCase();
    const role = document.getElementById('user-role-filter')?.value || '';
    return users.filter(u =>
        (u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)) &&
        (!role || u.role === role)
    );
}

function renderUsers() {
    // Sync metrics
    setText('m-total',    users.length);
    setText('m-students', users.filter(u => u.role === 'student').length);
    setText('m-teachers', users.filter(u => u.role === 'teacher').length);
    setText('u-total',    users.length);
    setText('u-students', users.filter(u => u.role === 'student').length);
    setText('u-teachers', users.filter(u => u.role === 'teacher').length);

    const filtered   = getFilteredUsers();
    const totalPages = Math.max(1, Math.ceil(filtered.length / USERS_PER_PAGE));
    if (userPage > totalPages) userPage = totalPages;
    const slice = filtered.slice((userPage - 1) * USERS_PER_PAGE, userPage * USERS_PER_PAGE);

    const tbody = document.getElementById('users-tbody');
    if (!slice.length) {
        tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><div class="empty-icon">👤</div><h4>No users found</h4><p>Try a different search or filter.</p></div></td></tr>`;
    } else {
       tbody.innerHTML = slice.map((u, i) => {
    // 1. Logic para sa Status Badge
   const statusClass = (u.status === 'approved' || u.status === 'Active') ? 'badge-good' : 'badge-danger';

    // 2. Logic para sa Approve Button (Lalabas lang kung hindi pa approved)
    const approveBtn = (u.status !== 'Approved' && u.status !== 'Active') 
        ? `<button class="tbl-btn edit" style="background:var(--success);color:white" onclick="approveUser(${u.id})">Approve</button>` 
        : '';

    return `
        <tr>
            <td style="color:var(--text-4);font-size:12px">${(userPage - 1) * USERS_PER_PAGE + i + 1}</td>
            <td><b>${Security.escape(u.name)}</b></td>
            <td style="color:var(--text-3)">${Security.escape(u.email)}</td>
            <td><span class="role-badge role-${Security.escape(u.role)}">${Security.escape(capitalize(u.role))}</span></td>
            <td style="font-size:12px;color:var(--text-3)">${Security.escape(u.joined)}</td>
            <td><span class="status-badge ${statusClass}">${Security.escape(u.status)}</span></td>
            <td>
                ${approveBtn}
                <button class="tbl-btn edit" onclick="editUser(${u.id})">Edit</button>
                <button class="tbl-btn del"  onclick="deleteUser(${u.id})">Delete</button>
            </td>
        </tr>`;
}).join('');
window.approveUser = function(userId) {
    // Siguraduhin na gumagana ang Swal
    Swal.fire({
        title: 'Approve User?',
        text: "Gagawing active ang account na ito.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/users/${userId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(async res => {
                const data = await res.json();
                if (res.ok) {
                    Swal.fire('Approved!', data.message || 'Active na ang user.', 'success');
                    
                    // I-update ang UI nang hindi nire-refresh ang page
                    const user = users.find(u => u.id == userId);
                    if (user) {
                        user.status = 'approved'; // Dapat small letter 'approved'
                    }
                    renderUsers(); 
                } else {
                    Swal.fire('Error', data.message || 'Hindi ma-approve ang user.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Connection failed.', 'error');
            });
        }
    });
};
    }

    // Pagination
    const pg = document.getElementById('user-pagination');
    pg.innerHTML = '';
    pg.appendChild(makePgBtn('‹ Prev', userPage === 1, () => { userPage--; renderUsers(); }));
    for (let i = 1; i <= totalPages; i++) {
        const btn = makePgBtn(i, false, () => { userPage = i; renderUsers(); });
        if (i === userPage) btn.classList.add('active');
        pg.appendChild(btn);
    }
    pg.appendChild(makePgBtn('Next ›', userPage === totalPages, () => { userPage++; renderUsers(); }));
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
    // Use .value (not innerHTML) — safe from XSS
    document.getElementById('u-name').value   = u.name;
    document.getElementById('u-email').value  = u.email;
    document.getElementById('u-role').value   = u.role;
    document.getElementById('u-status').value = u.status;
    openModal('modal-user');
}

function saveUser() {
    const name   = Security.sanitize(document.getElementById('u-name').value);
    const email  = Security.sanitize(document.getElementById('u-email').value);
    const role   = document.getElementById('u-role').value;
    const status = document.getElementById('u-status').value;

    if (!name || name.length < 2) return warn('Missing field', 'Please enter a valid full name.');
    if (!Security.isValidEmail(email)) return warn('Invalid email', 'Please enter a valid email address.');
    if (!Security.isValidRole(role))   return warn('Invalid role', 'Please select a valid role.');
    if (!Security.isValidStatus(status)) return warn('Invalid status', 'Please select a valid status.');

    if (userEditId) {
        const u = users.find(x => x.id === userEditId);
        if (u) Object.assign(u, { name, email, role, status });
        logEvent('content', 'User Updated', `${name}'s profile was edited`, 'Updated');
    } else {
        if (users.some(u => u.email.toLowerCase() === email.toLowerCase())) {
            return warn('Duplicate email', 'A user with this email already exists.');
        }
        users.push({ id: Date.now(), name, email, role, status, joined: dateNow() });
        logEvent('registration', 'New User Added', `${name} joined as ${role}`, 'New');
    }

    closeModal('modal-user');
    renderUsers();
    renderHome();
    toast('success', userEditId ? 'User updated successfully.' : 'New user added successfully.');
}

function deleteUser(id) {
    const u = users.find(x => x.id === id);
    if (!u) return;
    Swal.fire({
        title: 'Delete User?',
        html: `Remove <strong>${Security.escape(u.name)}</strong>? This cannot be undone.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Yes, delete',
    }).then(r => {
        if (r.isConfirmed) {
            logEvent('system', 'User Deleted', `Account for ${u.name} removed`, 'System');
            users = users.filter(x => x.id !== id);
            renderUsers();
            renderHome();
            toast('success', 'User deleted.');
        }
    });
}

/* ============================================================
   ANALYTICS
   ============================================================ */
function renderAnalytics() {
    const students = users.filter(u => u.role === 'student');
    setText('a-dau',         Math.floor(students.length * 0.6));
    setText('a-score',       students.length ? '—' : '—');
    setText('a-completions', 0);

    // Bar chart
    const chartEl = document.getElementById('reg-chart');
    if (!users.length) {
        chartEl.innerHTML = '<div class="empty-state"><div class="empty-icon">📊</div><h4>No registration data yet</h4><p>Charts will populate as users join.</p></div>';
    } else {
        const days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        const base = Math.max(1, Math.floor(users.length / 7));
        const vals = days.map(() => Math.max(0, base + Math.floor(Math.random() * 3)));
        const maxV = Math.max(...vals, 1);
        chartEl.innerHTML = `<div class="bar-chart">` + days.map((d, i) => `
            <div class="bar-group">
                <div class="bar-val">${vals[i]}</div>
                <div class="bar" style="height:${Math.round((vals[i]/maxV)*120)}px;background:linear-gradient(180deg,#60a5fa,#2563eb)"></div>
                <div class="bar-label">${d}</div>
            </div>`).join('') + `</div>`;
    }

    // Subject progress — empty until data exists
    const subjEl = document.getElementById('subject-progress');
    if (!contents.length) {
        subjEl.innerHTML = '<div class="empty-state"><div class="empty-icon">📈</div><h4>No progress data yet</h4><p>Data appears as students complete modules.</p></div>';
    } else {
        const subjects = ['Algebra','Geometry','Calculus','Statistics'];
        const colors   = ['#2563eb','#10b981','#f97316','#a855f7'];
        subjEl.innerHTML = subjects.map((s, i) => `
            <div class="progress-row">
                <div class="progress-label"><span>${s}</span><span>0%</span></div>
                <div class="progress-bar"><div class="progress-fill" style="width:0%;background:${colors[i]}"></div></div>
            </div>`).join('');
    }

    // Distribution
    const donutEl = document.getElementById('donut-row');
    if (!users.length) {
        donutEl.innerHTML = '<div class="empty-state"><div class="empty-icon">🍩</div><h4>No users yet</h4><p>Add users to see role distribution.</p></div>';
    } else {
        const total = users.length;
        const dist = [
            { label:'Students', count:users.filter(u=>u.role==='student').length, color:'var(--blue)', bg:'var(--blue-light)' },
            { label:'Teachers', count:users.filter(u=>u.role==='teacher').length, color:'var(--green)', bg:'var(--green-light)' },
            { label:'Admins',   count:users.filter(u=>u.role==='admin').length,   color:'var(--orange)', bg:'var(--orange-light)' },
            { label:'Inactive', count:users.filter(u=>u.status==='Inactive').length, color:'var(--purple)', bg:'var(--purple-light)' },
        ];
        donutEl.innerHTML = `<div class="donut-row">` + dist.map(d => `
            <div class="donut-item">
                <div class="donut-circle" style="background:${d.bg};color:${d.color}">${Math.round(d.count/total*100)}%</div>
                <div class="donut-info">
                    <div class="donut-pct">${d.count}</div>
                    <div class="donut-lbl">${d.label}</div>
                </div>
            </div>`).join('') + `</div>`;
    }

    // Top students
    const tbody  = document.getElementById('top-students-tbody');
    const studs  = users.filter(u => u.role === 'student');
    if (!studs.length) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><div class="empty-icon">🏆</div><h4>No students yet</h4><p>Add students to see rankings.</p></div></td></tr>`;
    } else {
        const medals = ['🥇','🥈','🥉'];
        tbody.innerHTML = studs.slice(0, 5).map((s, i) => `
            <tr>
                <td>${medals[i] || (i + 1)}</td>
                <td><b>${Security.escape(s.name)}</b></td>
                <td style="color:var(--green);font-weight:700">—</td>
                <td>0</td>
                <td>—</td>
            </tr>`).join('');
    }
}

/* ============================================================
   CONTENT
   ============================================================ */
const SUBJECT_EMOJIS = { Algebra:'➕', Geometry:'📐', Calculus:'∞', Statistics:'📊' };

function getFilteredContent() {
    const q    = Security.sanitize(document.getElementById('content-search')?.value || '').toLowerCase();
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
        grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1"><div class="empty-icon">📚</div><h4>No modules found</h4><p>Click "+ Add Module" to create your first learning module.</p></div>`;
        return;
    }

    grid.innerHTML = filtered.map(c => `
        <div class="content-card">
            <div class="content-thumb" style="background:${c.status === 'Published' ? '#f0fdf4' : '#fff7ed'}">${Security.escape(c.emoji)}</div>
            <div class="content-body">
                <div class="content-title">${Security.escape(c.title)}</div>
                <div class="content-meta">${Security.escape(c.subject)} &bull; <span class="status-badge ${c.status === 'Published' ? 'badge-good' : 'badge-system'}">${Security.escape(c.status)}</span></div>
                <div style="font-size:12px;color:var(--text-3);margin-bottom:10px;line-height:1.4">${Security.escape(c.desc)}</div>
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
    const title   = Security.sanitize(document.getElementById('c-title').value);
    const subject = document.getElementById('c-subject').value;
    const desc    = Security.sanitize(document.getElementById('c-desc').value);
    const status  = document.getElementById('c-status').value;

    if (!title || title.length < 2) return warn('Missing title', 'Please enter a module title.');
    if (!Security.isValidSubject(subject))   return warn('Invalid subject', 'Please select a valid subject.');
    if (!Security.isValidModStatus(status))  return warn('Invalid status', 'Please select Published or Draft.');

    if (contentEditId) {
        const c = contents.find(x => x.id === contentEditId);
        if (c) Object.assign(c, { title, subject, desc: desc || c.desc, status, emoji: SUBJECT_EMOJIS[subject] || '📚' });
        logEvent('content', 'Module Updated', `"${title}" was edited`, 'Updated');
    } else {
        contents.push({ id: Date.now(), title, subject, desc: desc || 'No description.', status, emoji: SUBJECT_EMOJIS[subject] || '📚' });
        logEvent('content', 'Module Created', `"${title}" added to ${subject}`, 'Published');
    }

    closeModal('modal-content');
    renderContent();
    toast('success', 'Module saved successfully.');
}

function deleteContent(id) {
    const c = contents.find(x => x.id === id);
    if (!c) return;
    Swal.fire({
        title: 'Delete Module?',
        html: `Remove <strong>${Security.escape(c.title)}</strong>? This cannot be undone.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Yes, delete',
    }).then(r => {
        if (r.isConfirmed) {
            logEvent('content', 'Module Deleted', `"${c.title}" was removed`, 'Deleted');
            contents = contents.filter(x => x.id !== id);
            renderContent();
            toast('success', 'Module deleted.');
        }
    });
}

/* ============================================================
   ACTIVITY
   ============================================================ */
function logEvent(type, title, sub, badge) {
    activity.unshift({ type, title, sub, badge: badge || 'Event', time: 'just now', ts: Date.now() });
    if (activity.length > 50) activity.pop();
}

function renderActivity() {
    const filter   = document.getElementById('activity-filter')?.value || '';
    const filtered = filter ? activity.filter(a => a.type === filter) : activity;

    const today = activity.filter(a => (Date.now() - a.ts) < 86400000);
    setText('ac-events', today.length);
    setText('ac-logins', today.filter(a => a.type === 'login').length);
    setText('ac-errors', today.filter(a => a.type === 'error').length);

    const tl = document.getElementById('activity-timeline');
    if (!filtered.length) {
        tl.innerHTML = '<div class="empty-state"><div class="empty-icon">📋</div><h4>No events logged yet</h4><p>Activity will appear here as users interact with the platform.</p></div>';
        return;
    }

    const dotColor = { registration:'blue', login:'green', content:'green', system:'orange', error:'red' };
    tl.innerHTML = filtered.map(a => `
        <div class="tl-item">
            <div class="tl-dot ${dotColor[a.type] || 'blue'}"></div>
            <div class="tl-title">${Security.escape(a.title)}</div>
            <div class="tl-sub">${Security.escape(a.sub)}</div>
            <div class="tl-time">${Security.escape(a.time)}</div>
        </div>`).join('');
}

function filterActivity() { renderActivity(); }

/* ============================================================
   SETTINGS
   ============================================================ */
function savePlatformInfo() {
    const name  = Security.sanitize(document.getElementById('s-platform-name').value);
    const email = Security.sanitize(document.getElementById('s-admin-email').value);
    if (!name || name.length < 2) return warn('Platform name required', 'Please enter a platform name.');
    if (email && !Security.isValidEmail(email)) return warn('Invalid email', 'Please enter a valid admin email.');
    logEvent('system', 'Settings Updated', 'Platform info was saved', 'System');
    toast('success', 'Platform info saved!');
}

function saveSettings(label) {
    logEvent('system', 'Settings Updated', `${label} preferences saved`, 'System');
    toast('success', `${Security.sanitize(label)} saved!`);
}

function confirmDanger(action, desc) {
    Swal.fire({
        title: Security.escape(action) + '?', text: desc,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Yes, confirm',
    }).then(r => {
        if (r.isConfirmed) {
            if (action === 'Clear All Logs') { activity = []; renderActivity(); }
            toast('success', Security.escape(action) + ' complete.');
        }
    });
}

/* ============================================================
   MODALS
   ============================================================ */
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

/* ============================================================
   LOGOUT
   ============================================================ */
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?', text: 'You will be logged out of your account.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#2563eb', cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!', cancelButtonText: 'Cancel',
    }).then(r => {
        if (r.isConfirmed) {
            Swal.fire({ icon:'success', title:'Logged out', text:'Goodbye!', timer:1500, timerProgressBar:true, showConfirmButton:false })
                .then(() => {
                    document.getElementById('logout-form').submit();
                });
        }
    });
}

/* ============================================================
   UTILITIES
   ============================================================ */
function setText(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val; // textContent is XSS-safe
}
function capitalize(str) { return str.charAt(0).toUpperCase() + str.slice(1); }
function initials(str) {
    return (str || '').split(' ').slice(0, 2).map(w => w[0] || '').join('').toUpperCase() || '?';
}
function dateNow() {
    return new Date().toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' });
}
function makePgBtn(label, disabled, handler) {
    const btn = document.createElement('button');
    btn.className   = 'pg-btn';
    btn.textContent = label; // textContent — safe
    btn.disabled    = disabled;
    btn.addEventListener('click', handler);
    return btn;
}
function warn(title, text) {
    Swal.fire({ icon:'warning', title, text, confirmButtonColor:'#2563eb' });
}
function toast(icon, title) {
    Swal.fire({ icon, title, timer:2000, timerProgressBar:true, showConfirmButton:false });
}

/* ============================================================
   GLOBAL EXPOSE (for onclick= attributes)
   ============================================================ */
Object.assign(window, {
    navigate, filterUsers, openAddUser, editUser, saveUser, deleteUser,
    filterContent, openAddContent, editContent, saveContent, deleteContent,
    filterActivity, savePlatformInfo, saveSettings, confirmDanger,
    openModal, closeModal, confirmLogout,
});

/* ============================================================
   INIT
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => { renderUsers();
    // Sidebar + bottom nav
    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', () => navigate(btn.dataset.page));
    });
    // Close modals on backdrop click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(overlay.id); });
    });
    // Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(o => closeModal(o.id));
    });
    // Initial render
    renderHome();
    renderUsers();
});