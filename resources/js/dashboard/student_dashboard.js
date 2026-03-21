/**
 * student_dashboard.js
 * Path: resources/js/dashboard/student_dashboard.js
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
    sanitize(str) {
        if (str == null) return '';
        return String(str).replace(/[<>"'`]/g, '').trim();
    },
};

/* ============================================================
   STATE — populated from backend via Laravel/Blade
   ============================================================ */
let modules  = [];
let quizzes  = [];
let activity = [];

/* ============================================================
   NAVIGATION
   ============================================================ */
function navigate(page) {
    const allowed = ['home', 'modules', 'progress', 'profile'];
    if (!allowed.includes(page)) return;

    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sidebar-item').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));

    document.getElementById('page-' + page).classList.add('active');
    document.querySelectorAll('[data-page="' + page + '"]').forEach(b => b.classList.add('active'));
    window.scrollTo(0, 0);

    if (page === 'home')     renderHome();
    if (page === 'modules')  renderModules();
    if (page === 'progress') renderProgress();
    if (page === 'profile')  renderProfile();
}

/* ============================================================
   HOME
   ============================================================ */
function renderHome() {
    const totalModules    = modules.length;
    const doneModules     = modules.filter(m => m.progress === 100).length;
    const overallProgress = totalModules
        ? Math.round(modules.reduce((s, m) => s + m.progress, 0) / totalModules)
        : 0;
    const quizzesDone = quizzes.filter(q => q.done).length;
    const totalQuizzes = quizzes.length || 20;

    setText('m-progress', overallProgress + '%');
    setText('m-quizzes',  quizzesDone + '/' + totalQuizzes);
    setText('m-streak',   0);

    // Module list preview
    const listEl = document.getElementById('home-module-list');
    if (!modules.length) {
        listEl.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">📚</div>
                <h4>No modules yet</h4>
                <p>Your learning modules will appear here once they are assigned.</p>
            </div>`;
        return;
    }

    listEl.innerHTML = modules.map(m => `
        <div class="module-item">
            <div class="module-title-row">
                <span class="status-icon">${m.progress === 100 ? '✓' : '—'}</span>
                <span class="module-name">${Security.escape(m.title)}</span>
                <span class="percentage ${m.progress === 100 ? '' : 'blue'}">${Security.escape(String(m.progress))}%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-fill ${m.progress === 100 ? '' : 'blue'}" style="width:${Security.escape(String(m.progress))}%"></div>
            </div>
            <button class="view-topics-btn" onclick="viewModule(${m.id})">View Topics</button>
        </div>`).join('');
}

/* ============================================================
   MODULES
   ============================================================ */
function renderModules() {
    const listEl = document.getElementById('modules-list');
    if (!modules.length) {
        listEl.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">📖</div>
                <h4>No modules available</h4>
                <p>Check back later for learning materials.</p>
            </div>`;
        return;
    }

    listEl.innerHTML = modules.map(m => `
        <div class="module-item">
            <div class="module-title-row">
                <span class="status-icon">${m.progress === 100 ? '✓' : '—'}</span>
                <span class="module-name">${Security.escape(m.title)}</span>
                <span class="percentage ${m.progress === 100 ? '' : 'blue'}">${Security.escape(String(m.progress))}%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-fill ${m.progress === 100 ? '' : 'blue'}" style="width:${Security.escape(String(m.progress))}%"></div>
            </div>
            <button class="view-topics-btn" onclick="viewModule(${m.id})">View Topics</button>
        </div>`).join('');
}

function viewModule(id) {
    const m = modules.find(x => x.id === id);
    if (!m) return;
    Swal.fire({
        title: Security.escape(m.title),
        html: `
            <div style="text-align:left;font-family:'Plus Jakarta Sans',sans-serif">
                <p style="margin-bottom:8px;color:#6b7280;font-size:13px">Module Details</p>
                <div style="background:#f4f6fb;border-radius:10px;padding:14px;margin-bottom:12px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span style="font-size:12px;color:#6b7280;font-weight:600">Progress</span>
                        <span style="font-size:13px;font-weight:800;color:#111827">${Security.escape(String(m.progress))}%</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-size:12px;color:#6b7280;font-weight:600">Status</span>
                        <span style="font-size:12px;font-weight:700;color:${m.progress === 100 ? '#10b981' : '#2563eb'}">${m.progress === 100 ? 'Completed' : 'In Progress'}</span>
                    </div>
                </div>
            </div>`,
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Continue Learning',
        showCancelButton: true,
        cancelButtonText: 'Close',
    });
}

/* ============================================================
   PROGRESS
   ============================================================ */
function renderProgress() {
    const totalModules    = modules.length;
    const overallProgress = totalModules
        ? Math.round(modules.reduce((s, m) => s + m.progress, 0) / totalModules)
        : 0;
    const doneModules  = modules.filter(m => m.progress === 100).length;
    const quizzesDone  = quizzes.filter(q => q.done).length;
    const totalQuizzes = quizzes.length || 20;

    setText('p-overall',  overallProgress + '%');
    setText('p-modules',  doneModules + '/' + totalModules);
    setText('p-quizzes',  quizzesDone + '/' + totalQuizzes);

    // Per-module progress bars
    const progEl = document.getElementById('progress-list');
    if (!modules.length) {
        progEl.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">📈</div>
                <h4>No progress data yet</h4>
                <p>Complete some modules to see your progress here.</p>
            </div>`;
        return;
    }

    progEl.innerHTML = modules.map(m => `
        <div class="module-item">
            <div class="module-title-row">
                <span class="status-icon">${m.progress === 100 ? '✓' : '—'}</span>
                <span class="module-name">${Security.escape(m.title)}</span>
                <span class="percentage ${m.progress === 100 ? '' : 'blue'}">${Security.escape(String(m.progress))}%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-fill ${m.progress === 100 ? '' : 'blue'}" style="width:${Security.escape(String(m.progress))}%"></div>
            </div>
        </div>`).join('');
}

/* ============================================================
   PROFILE
   ============================================================ */
function renderProfile() {
    const actEl = document.getElementById('profile-activity');
    if (!activity.length) {
        actEl.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h4>No recent activity</h4>
                <p>Your completed quizzes and modules will appear here.</p>
            </div>`;
        return;
    }

    actEl.innerHTML = activity.slice(0, 5).map(a => `
        <div class="module-item" style="cursor:default">
            <div class="module-title-row">
                <span class="status-icon">✓</span>
                <span class="module-name">${Security.escape(a.title)}</span>
                <span class="percentage blue" style="font-size:11px;color:#9ca3af">${Security.escape(a.time)}</span>
            </div>
        </div>`).join('');
}

function saveProfile() {
    const name = Security.sanitize(document.getElementById('p-name')?.value || '');
    if (!name || name.length < 2) {
        return Swal.fire({ icon: 'warning', title: 'Name required', text: 'Please enter your full name.', confirmButtonColor: '#2563eb' });
    }
    toast('success', 'Profile saved successfully!');
}

/* ============================================================
   LOGOUT
   ============================================================ */
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
function toast(icon, title) {
    Swal.fire({ icon, title, timer: 2000, timerProgressBar: true, showConfirmButton: false });
}

/* ============================================================
   GLOBAL EXPOSE (for onclick= attributes)
   ============================================================ */
Object.assign(window, {
    navigate,
    viewModule,
    saveProfile,
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

    // Initial render
    renderHome();
});