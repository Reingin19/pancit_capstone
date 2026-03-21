/* ================================
   STUDENT DASHBOARD — student_dashboard.js
   ================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Navigation ── */
    function navigate(page) {
        // Hide all pages
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));

        // Show target page
        const target = document.getElementById('page-' + page);
        if (target) target.classList.add('active');

        // Update bottom nav active state
        document.querySelectorAll('.nav-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });

        // Update sidebar active state
        document.querySelectorAll('.sidebar-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Wire up all data-page buttons (sidebar + bottom nav)
    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', function () {
            navigate(this.dataset.page);
        });
    });

    /* ── Logout — SweetAlert2 confirmation ── */
    window.confirmLogout = function () {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out of your account.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Laravel: document.getElementById('logout-form').submit();
                toast('success', 'Logged out successfully.');
            }
        });
    };

    /* ── Toast utility ── */
    window.toast = function (icon, title) {
        Swal.fire({ icon, title, timer: 2000, timerProgressBar: true, showConfirmButton: false });
    };

    /* ── Expose navigate globally ── */
    window.navigate = navigate;

});