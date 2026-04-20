<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Bubog NHS</title>

    <link rel="icon" href="{{ asset('image/logo-removebg-preview.png') }}">

    @vite([
        'resources/css/login/student_login.css',
        'resources/js/login/student_login.js'
    ])
</head>
<body>

<div class="main-container">
    <a href="{{ url('/') }}" class="back-home">← Back to Home</a>

    <div class="portal-card" id="portal-card">

        <div class="form-side">
            <div class="form-content">

                <div class="icon-header">
                    <img src="{{ asset('image/student.png') }}" alt="student Icon">
                </div>

                <h1>Student Portal</h1>
                <p id="sub-text">Sign in to your account</p>

                @if ($errors->any())
                    <div class="alert alert-danger" style="background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; border: 1px solid #fecaca;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="tab-switcher">
                    <button id="login-tab" type="button" class="active">Login</button>
                    <button id="signup-tab" type="button">Sign Up</button>
                </div>

                <div id="login-form-container">
                    <form method="POST" action="{{ route('student.login.submit') }}" autocomplete="off">
                        @csrf

                        {{-- Dummy inputs para linlangin ang browser autofill --}}
                        {{-- Dito muna mag-a-autofill ang browser, hindi sa actual inputs --}}
                        <input type="email" style="display:none" aria-hidden="true">
                        <input type="password" style="display:none" aria-hidden="true">

                        <div class="input-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autocomplete="off" required>
                        </div>

                        <div class="input-group">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Enter your password" autocomplete="new-password" required>
                        </div>

                        <button type="submit" class="btn-sign">Sign In</button>
                    </form>
                </div>

                <div id="signup-form-container" class="hidden">
    <form method="POST" action="{{ route('student.register') }}" autocomplete="off">
        @csrf

        {{-- Dummy inputs para linlangin ang browser autofill --}}
        <input type="text" style="display:none" aria-hidden="true">
        <input type="email" style="display:none" aria-hidden="true">
        <input type="password" style="display:none" aria-hidden="true">

        <div class="input-group">
            <label>Student ID</label>
            <input type="text" name="student_id" placeholder="e.g. 2024-0001" value="{{ old('student_id') }}" required autocomplete="off">
        </div>

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="name" placeholder="Enter your Username" value="{{ old('name') }}" autocomplete="off" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}" autocomplete="off" required>
        </div>

        <div class="input-group">
            <label>Section</label>
            <select name="section" required style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: white; font-size: 14px;">
                <option value="" disabled selected>Select your Section</option>
                <option value="1">Section 1</option>
                <option value="2">Section 2</option>
                <option value="3">Section 3</option>
            </select>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your Password" autocomplete="new-password" required>
        </div>

        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm your Password" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn-sign">Create Account</button>
    </form>
</div>

            </div>
        </div>

        <div class="image-side" id="image-side">
            <div class="logo-wrapper">
                <img 
                    src="{{ asset('image/logo-removebg-preview.png') }}" 
                    alt="School Logo" 
                    class="school-logo"
                >
            </div>
        </div>

    </div>
</div>

<script>
    // I-clear ang lahat ng input fields pagkatapos mag-load ang page
    // Para maiwasan ang browser autofill / autocomplete
    window.addEventListener('load', function () {
        document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"]').forEach(function (input) {
            input.value = ''; // Burahin ang nakalagay na value sa bawat input
        });
    });
</script>

</body>
</html>
