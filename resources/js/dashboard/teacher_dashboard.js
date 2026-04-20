/**
 * teacher_dashboard.js
 * Path: resources/js/dashboard/teacher_dashboard.js
 *
 * Install deps:   npm install sweetalert2
 * Dev server:     npm run dev
 * Production:     npm run build
 */

import { supabase } from './supabaseClient' // Siguraduhing tama ang path
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
    isValidStatus(s) { return ['Excellent','Good','Average','Needs Help'].includes(s); },
};

/* ============================================================
   STATE — starts completely empty (populated from backend)
   ============================================================ */
let students  = [];
let feedbacks = [];
let activity  = [];

let feedbackTargetId = null;
const STUDENTS_PER_PAGE = 6;
let studentPage = 1;

/* ============================================================
/* ============================================================
   NAVIGATION (Updated with Modules)
   ============================================================ */
function navigate(page) {
    // 1. Idagdag ang 'modules' sa allowed list
    const allowed = ['home', 'modules', 'students', 'progress', 'reports', 'profile'];
    if (!allowed.includes(page)) return;

    // 2. Alisin ang 'active' class sa lahat
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sidebar-item').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));

    // 3. I-activate ang tamang page at buttons
    const targetPage = document.getElementById('page-' + page);
    if (targetPage) {
        targetPage.classList.add('active');
    }
    
    document.querySelectorAll('[data-page="' + page + '"]').forEach(b => b.classList.add('active'));
    
    window.scrollTo(0, 0);

    // 4. Tawagin ang kaukulang render function
    if (page === 'home')     renderHome();
    if (page === 'modules')  renderModules(); // Idinagdag ito
    if (page === 'students') renderStudents();
    if (page === 'progress') renderProgress();
    if (page === 'reports')  renderReports();
    if (page === 'profile')  renderProfile();
}

/**
 * Halimbawa ng Render function para sa Modules
 * Dito mo kukunin ang data galing sa database (Laravel API)
 */
function renderModules() {
    console.log("Loading modules...");
    // Dito mo pwedeng tawagin ang fetch() para i-refresh ang table list
}

/* ============================================================
   HOME
   ============================================================ */
function renderHome() {
    setText('m-total',    students.length);
    setText('m-avg',      avgProgress() + '%');
    setText('m-pending',  feedbacks.filter(f => !f.sent).length);
    setText('m-messages', 0);

    const listEl = document.getElementById('home-student-list');
    if (!students.length) {
        listEl.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">👩‍🎓</div>
                <h4>No students yet</h4>
                <p>Students will appear here once they enroll in your class.</p>
            </div>`;
        return;
    }

    listEl.innerHTML = students.slice(0, 4).map(s => `
        <div class="student-item" onclick="navigate('students')">
            <div class="student-info">
                <div class="student-avatar">${Security.escape(initials(s.name))}</div>
                <div>
                    <div class="student-name">${Security.escape(s.name)}</div>
                    <div class="student-meta">Progress: ${Security.escape(String(s.progress))}%</div>
                </div>
            </div>
            <span class="status-badge ${badgeClass(s.status)}">${Security.escape(s.status)}</span>
        </div>`).join('');
}

/* ============================================================
   STUDENTS
   ============================================================ */
function getFilteredStudents() {
    const q      = Security.sanitize(document.getElementById('student-search')?.value || '').toLowerCase();
    const status = document.getElementById('student-status-filter')?.value || '';
    return students.filter(s =>
        s.name.toLowerCase().includes(q) &&
        (!status || s.status === status)
    );
}

function renderStudents() {
    setText('s-total',    students.length);
    setText('s-avg',      avgProgress() + '%');
    setText('s-help',     students.filter(s => s.status === 'Needs Help').length);
    setText('s-excellent', students.filter(s => s.status === 'Excellent').length);

    const filtered   = getFilteredStudents();
    const totalPages = Math.max(1, Math.ceil(filtered.length / STUDENTS_PER_PAGE));
    if (studentPage > totalPages) studentPage = totalPages;
    const slice = filtered.slice((studentPage - 1) * STUDENTS_PER_PAGE, studentPage * STUDENTS_PER_PAGE);

    const tbody = document.getElementById('students-tbody');
    if (!slice.length) {
        tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><div class="empty-icon">👤</div><h4>No students found</h4><p>Try a different search or filter.</p></div></td></tr>`;
    } else {
        tbody.innerHTML = slice.map((s, i) => `
            <tr>
                <td style="color:var(--text-4);font-size:12px">${(studentPage - 1) * STUDENTS_PER_PAGE + i + 1}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div class="student-avatar" style="width:30px;height:30px;font-size:10px">${Security.escape(initials(s.name))}</div>
                        <b>${Security.escape(s.name)}</b>
                    </div>
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div class="progress-bar" style="width:80px;height:6px;display:inline-block">
                            <div class="progress-fill" style="width:${Security.escape(String(s.progress))}%;background:${progressColor(s.progress)}"></div>
                        </div>
                        <span style="font-size:12px;font-weight:700;color:var(--text-2)">${Security.escape(String(s.progress))}%</span>
                    </div>
                </td>
                <td><span class="status-badge ${badgeClass(s.status)}">${Security.escape(s.status)}</span></td>
                <td style="font-size:12px;color:var(--text-3)">${Security.escape(s.lastActive)}</td>
                <td>
                    <button class="tbl-btn view"     onclick="viewStudent(${s.id})">View</button>
                    <button class="tbl-btn feedback" onclick="openFeedback(${s.id})">Feedback</button>
                </td>
            </tr>`).join('');
    }

    // Pagination
    const pg = document.getElementById('student-pagination');
    pg.innerHTML = '';
    pg.appendChild(makePgBtn('‹ Prev', studentPage === 1, () => { studentPage--; renderStudents(); }));
    for (let i = 1; i <= totalPages; i++) {
        const btn = makePgBtn(i, false, () => { studentPage = i; renderStudents(); });
        if (i === studentPage) btn.classList.add('active');
        pg.appendChild(btn);
    }
    pg.appendChild(makePgBtn('Next ›', studentPage === totalPages, () => { studentPage++; renderStudents(); }));
}

function filterStudents() { studentPage = 1; renderStudents(); }

function viewStudent(id) {
    const s = students.find(x => x.id === id);
    if (!s) return;
    Swal.fire({
        title: Security.escape(s.name),
        html: `
            <div style="text-align:left;font-family:'Plus Jakarta Sans',sans-serif">
                <p style="margin-bottom:8px;color:#6b7280;font-size:13px">Student Details</p>
                <div style="background:#f4f6fb;border-radius:10px;padding:14px;margin-bottom:12px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span style="font-size:12px;color:#6b7280;font-weight:600">Progress</span>
                        <span style="font-size:13px;font-weight:800;color:#111827">${Security.escape(String(s.progress))}%</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span style="font-size:12px;color:#6b7280;font-weight:600">Status</span>
                        <span style="font-size:12px;font-weight:700">${Security.escape(s.status)}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:12px;color:#6b7280;font-weight:600">Last Active</span>
                        <span style="font-size:12px;color:#9ca3af">${Security.escape(s.lastActive)}</span>
                    </div>
                </div>
                <p style="font-size:12px;color:#6b7280">${Security.escape(s.notes || 'No additional notes.')}</p>
            </div>`,
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Send Feedback',
        showCancelButton: true,
        cancelButtonText: 'Close',
    }).then(r => {
        if (r.isConfirmed) openFeedback(id);
    });
}

/* ============================================================
   FEEDBACK
   ============================================================ */
function openFeedback(id) {
    const s = students.find(x => x.id === id);
    if (!s) return;
    feedbackTargetId = id;
    document.getElementById('fb-student-name').textContent = s.name;
    document.getElementById('fb-message').value = '';
    document.getElementById('fb-type').value = 'encouragement';
    openModal('modal-feedback');
}

function saveFeedback() {
    const message = Security.sanitize(document.getElementById('fb-message').value);
    const type    = document.getElementById('fb-type').value;
    const s       = students.find(x => x.id === feedbackTargetId);
    if (!s) return;

    if (!message || message.length < 5) {
        return warn('Message required', 'Please write a feedback message (at least 5 characters).');
    }

    feedbacks.push({
        id: Date.now(),
        studentId: feedbackTargetId,
        studentName: s.name,
        message,
        type,
        sent: true,
        date: dateNow(),
    });

    logActivity('Feedback Sent', `Feedback sent to ${s.name}`, 'success');
    closeModal('modal-feedback');
    renderHome();
    toast('success', `Feedback sent to ${Security.escape(s.name)}!`);
}

/* ============================================================
   PROGRESS
   ============================================================ */
function renderProgress() {
    const progEl = document.getElementById('progress-list');

    if (!students.length) {
        progEl.innerHTML = `<div class="empty-state"><div class="empty-icon">📈</div><h4>No student data yet</h4><p>Progress will appear here as students complete activities.</p></div>`;
        return;
    }

    progEl.innerHTML = students.map(s => `
        <div class="progress-row">
            <div class="progress-label">
                <span style="display:flex;align-items:center;gap:8px">
                    <div class="student-avatar" style="width:24px;height:24px;font-size:9px;flex-shrink:0">${Security.escape(initials(s.name))}</div>
                    ${Security.escape(s.name)}
                </span>
                <span style="font-weight:800;color:${progressColor(s.progress)}">${Security.escape(String(s.progress))}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:${Security.escape(String(s.progress))}%;background:${progressColor(s.progress)}"></div>
            </div>
        </div>`).join('');

    // Bar chart by status
    const chartEl = document.getElementById('progress-chart');
    const groups  = [
        { label: 'Excellent', count: students.filter(s => s.status === 'Excellent').length,   color: '#2563eb' },
        { label: 'Good',      count: students.filter(s => s.status === 'Good').length,        color: '#10b981' },
        { label: 'Average',   count: students.filter(s => s.status === 'Average').length,     color: '#f97316' },
        { label: 'Help',      count: students.filter(s => s.status === 'Needs Help').length,  color: '#ef4444' },
    ];
    const maxV = Math.max(...groups.map(g => g.count), 1);
    chartEl.innerHTML = `<div class="bar-chart">` + groups.map(g => `
        <div class="bar-group">
            <div class="bar-val">${g.count}</div>
            <div class="bar" style="height:${Math.round((g.count / maxV) * 120)}px;background:${g.color}"></div>
            <div class="bar-label">${g.label}</div>
        </div>`).join('') + `</div>`;
}

/* ============================================================
   REPORTS
   ============================================================ */
function renderReports() {
    setText('r-total',    students.length);
    setText('r-avg',      avgProgress() + '%');
    setText('r-feedback', feedbacks.length);

    const tbody = document.getElementById('reports-tbody');
    if (!students.length) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><div class="empty-icon">📄</div><h4>No report data yet</h4><p>Reports will populate as students progress through activities.</p></div></td></tr>`;
        return;
    }

    tbody.innerHTML = students.map((s, i) => `
        <tr>
            <td style="color:var(--text-4);font-size:12px">${i + 1}</td>
            <td><b>${Security.escape(s.name)}</b></td>
            <td>
                <div style="display:flex;align-items:center;gap:8px">
                    <div class="progress-bar" style="width:70px;height:6px;display:inline-block">
                        <div class="progress-fill" style="width:${Security.escape(String(s.progress))}%;background:${progressColor(s.progress)}"></div>
                    </div>
                    <span style="font-size:12px;font-weight:700">${Security.escape(String(s.progress))}%</span>
                </div>
            </td>
            <td><span class="status-badge ${badgeClass(s.status)}">${Security.escape(s.status)}</span></td>
            <td style="font-size:12px;color:var(--text-3)">${feedbacks.filter(f => f.studentId === s.id).length} sent</td>
        </tr>`).join('');
}

function generatePDF() {
    if (!students.length) return warn('No data', 'There are no students to generate a report for.');
    Swal.fire({
        icon: 'info',
        title: 'Generate PDF',
        text: 'This will generate a printable report for all students.',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Generate',
    }).then(r => {
        if (r.isConfirmed) {
            logActivity('Report Generated', 'PDF report was created', 'report');
            toast('success', 'PDF report generated successfully!');
        }
    });
}

/* ============================================================
   PROFILE
   ============================================================ */
function renderProfile() {
    // Profile page is mostly static; just ensure activity list renders
    const actEl = document.getElementById('profile-activity');
    if (!activity.length) {
        actEl.innerHTML = `<div class="empty-state"><div class="empty-icon">📋</div><h4>No recent activity</h4><p>Your actions will appear here.</p></div>`;
        return;
    }
    actEl.innerHTML = activity.slice(0, 5).map(a => `
        <div class="student-item" style="cursor:default">
            <div class="student-info">
                <div class="student-avatar" style="background:linear-gradient(135deg,#60a5fa,#2563eb)">${Security.escape(initials(a.title))}</div>
                <div>
                    <div class="student-name">${Security.escape(a.title)}</div>
                    <div class="student-meta">${Security.escape(a.sub)}</div>
                </div>
            </div>
            <span class="status-badge badge-new">${Security.escape(a.time)}</span>
        </div>`).join('');
}

function saveProfile() {
    const name  = Security.sanitize(document.getElementById('p-name')?.value || '');
    const email = Security.sanitize(document.getElementById('p-email')?.value || '');
    if (!name || name.length < 2) return warn('Name required', 'Please enter your full name.');
    logActivity('Profile Updated', 'Your profile information was saved', 'settings');
    toast('success', 'Profile saved successfully!');
}

/* ============================================================
   ACTIVITY LOG
   ============================================================ */
function logActivity(title, sub, type) {
    activity.unshift({ title, sub, type: type || 'general', time: 'just now', ts: Date.now() });
    if (activity.length > 30) activity.pop();
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
            Swal.fire({
                icon: 'success', title: 'Logged out', text: 'Goodbye!',
                timer: 1500, timerProgressBar: true, showConfirmButton: false,
            }).then(() => {
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
    if (el) el.textContent = val;
}
function initials(str) {
    return (str || '').split(' ').slice(0, 2).map(w => w[0] || '').join('').toUpperCase() || '?';
}
function dateNow() {
    return new Date().toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
}
function avgProgress() {
    if (!students.length) return 0;
    return Math.round(students.reduce((sum, s) => sum + s.progress, 0) / students.length);
}
function badgeClass(status) {
    return {
        'Excellent':  'badge-excellent',
        'Good':       'badge-good',
        'Average':    'badge-average',
        'Needs Help': 'badge-needs-help',
    }[status] || 'badge-needs-help';
}
function progressColor(pct) {
    if (pct >= 80) return '#2563eb';
    if (pct >= 60) return '#10b981';
    if (pct >= 40) return '#f97316';
    return '#ef4444';
}
function makePgBtn(label, disabled, handler) {
    const btn = document.createElement('button');
    btn.className   = 'pg-btn';
    btn.textContent = label;
    btn.disabled    = disabled;
    btn.addEventListener('click', handler);
    return btn;
}
function warn(title, text) {
    Swal.fire({ icon: 'warning', title, text, confirmButtonColor: '#2563eb' });
}
function toast(icon, title) {
    Swal.fire({ icon, title, timer: 2000, timerProgressBar: true, showConfirmButton: false });
}

/* ============================================================
   GLOBAL EXPOSE (for onclick= attributes)
   ============================================================ */
Object.assign(window, {
    navigate,
    filterStudents, viewStudent, openFeedback, saveFeedback,
    generatePDF,
    saveProfile,
    openModal, closeModal,
    confirmLogout,
});

/* ============================================================
   INIT
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => {
    // Sidebar + bottom nav — data-page routing
    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', () => navigate(btn.dataset.page));
    });

    // Logout buttons
    ['logout-btn-mobile', 'logout-btn-desktop'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', confirmLogout);
    });

    // Close modals on backdrop click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    // Escape key to close modals
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.open').forEach(o => closeModal(o.id));
        }
    });

    // Initial render
    renderHome();
    renderStudents();
});

if (typeof window.modulesData === 'undefined') {
    window.modulesData = [];
}



// Global storage
window.modulesData = [];

// ==========================================
// 1. FETCH & PERSISTENCE (Refresh Fix)
// ==========================================
window.loadModulesFromCloud = async function() {
    try {
        const { data, error } = await supabase.storage.from('modules').list();
        if (error) throw error;

        window.modulesData = data.map(file => {
            const { data: urlData } = supabase.storage.from('modules').getPublicUrl(file.name);
            return {
                id: file.id,
                title: file.name.split('_').slice(1).join('_'),
                file_name: file.name,
                file_url: urlData.publicUrl
            };
        });
        window.renderModules();
    } catch (err) {
        console.error("Error loading modules:", err.message);
    }
};

// ==========================================
// 2. RENDER FUNCTION
// ==========================================
window.renderModules = function() {
    const listContainer = document.getElementById('teacher-modules-list');
    if (!listContainer) return;

    listContainer.innerHTML = '';

    if (window.modulesData.length === 0) {
        listContainer.innerHTML = `
            <div style="text-align: center; padding: 40px 20px; border: 2px dashed #e2e8f0; border-radius: 10px;">
                <p style="color: #94a3b8; font-size: 0.9rem;">No modules uploaded yet.</p>
            </div>`;
        return;
    }

    window.modulesData.forEach((mod) => {
        const item = document.createElement('div');
        item.style = "display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 8px;";
        
        item.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: #eef2ff; padding: 8px; border-radius: 8px; color: #4f46e5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                </div>
                <div style="text-align: left;">
                    <h4 style="margin: 0; font-size: 0.95rem; font-weight: 600; color: #1e293b;">${mod.title}</h4>
                    <p style="margin: 0; font-size: 0.75rem; color: #64748b;">PDF Document</p>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <button onclick="window.previewPDF('${mod.file_url}', '${mod.title}')" style="padding: 6px 12px; background: white; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.8rem; color: #475569; font-weight: 600; cursor: pointer;">View</button>
                <button onclick="window.renameModule('${mod.id}')" style="padding: 6px 12px; background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 6px; font-size: 0.8rem; color: #16a34a; cursor: pointer;">Rename</button>
                <button onclick="window.deleteModule('${mod.id}', '${mod.file_name}')" style="padding: 6px 12px; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 6px; font-size: 0.8rem; color: #e11d48; cursor: pointer;">Delete</button>
            </div>
        `;
        listContainer.appendChild(item);
    });
};

// ==========================================
// 3. PREVIEW & CLOSE LOGIC (Full Screen Fix)
// ==========================================
window.previewPDF = function(url, title) {
    const modal = document.getElementById('modal-preview-pdf');
    const iframe = document.getElementById('pdf-viewer');
    const titleHeader = document.getElementById('preview-title');

    if (modal && iframe) {
        titleHeader.innerText = title;
        iframe.src = url;
        
        // Isang buong screen overlay
        modal.style.display = 'flex'; 
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100vw';
        modal.style.height = '100vh';
        modal.style.zIndex = '9999';
        modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
    }
};

window.closeModal = function(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        
        // I-reset ang iframe src para mawala ang loading sa background
        if (id === 'modal-preview-pdf') {
            const iframe = document.getElementById('pdf-viewer');
            if (iframe) iframe.src = ''; 
        }
    }
};

// ==========================================
// 4. UPLOAD, DELETE, RENAME
// ==========================================
window.handleUpload = async function(event) {
    event.preventDefault();
    const btn = document.getElementById('btn-upload-submit');
    const fileInput = document.getElementById('m-file');
    const titleInput = document.getElementById('m-title');
    const file = fileInput.files[0];

    if (!file) return alert("Pumili muna ng file!");

    btn.innerText = "Uploading...";
    btn.disabled = true;

    try {
        const rawFileName = `${Date.now()}_${titleInput.value || file.name}`;
        const { error } = await supabase.storage.from('modules').upload(rawFileName, file);
        if (error) throw error;

        alert("Success! Uploaded to Supabase.");
        window.closeModal('modal-upload-module');
        event.target.reset(); 
        window.loadModulesFromCloud();
    } catch (err) {
        alert("Error: " + err.message);
    } finally {
        btn.innerText = "Upload Now";
        btn.disabled = false;
    }
};

window.deleteModule = async function(id, fileName) {
    if (!confirm("Sigurado ka bang buburahin ito?")) return;
    try {
        const { error } = await supabase.storage.from('modules').remove([fileName]);
        if (error) throw error;
        window.loadModulesFromCloud();
    } catch (err) {
        alert("Delete Error: " + err.message);
    }
};

window.renameModule = function(id) {
    const newTitle = prompt("Enter new title for this module (Display only):");
    if (!newTitle) return;
    const mod = window.modulesData.find(m => m.id == id);
    if (mod) {
        mod.title = newTitle;
        window.renderModules();
    }
};

window.openModal = (id) => {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'flex';
};

// INITIAL LOAD
document.addEventListener('DOMContentLoaded', () => {
    window.loadModulesFromCloud();
});

