/* ================================
   STUDENT DASHBOARD — student_dashboard.js
   ================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Bottom Nav — active state ── */
    document.querySelectorAll('.nav-item').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    /* ── Sidebar Nav — active state ── */
    document.querySelectorAll('.sidebar-item').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.sidebar-item').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    /* ── Logout — SweetAlert2 confirmation ── */
    function confirmLogout() {
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
                document.getElementById('logout-form').submit();
            }
        });
    }

    ['logout-btn-mobile', 'logout-btn-desktop'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', confirmLogout);
    });

});