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

                {{-- Success message (from registration) --}}
                @if (session('success'))
                    <div class="alert alert-success" style="background-color: #dcfce7; color: #16a34a; padding: 10px; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; border: 1px solid #bbf7d0;">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Validation errors --}}
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

                {{-- LOGIN FORM --}}
                <div id="login-form-container">
                    <form method="POST" action="{{ route('student.login.submit') }}" autocomplete="off">
                        @csrf

                        {{-- Dummy inputs to trick browser autofill --}}
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

                    <p style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #64748b;">
                        Don't have an account?
                        <a href="#" id="go-to-signup" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Sign up here</a>
                    </p>
                </div>

                {{-- SIGN UP FORM --}}
                <div id="signup-form-container" class="hidden">
                    <form method="POST" action="{{ route('student.register') }}" autocomplete="off">
                        @csrf

                        {{-- Dummy inputs to trick browser autofill --}}
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
                                <option value="1" {{ old('section') == '1' ? 'selected' : '' }}>Section 1</option>
                                <option value="2" {{ old('section') == '2' ? 'selected' : '' }}>Section 2</option>
                                <option value="3" {{ old('section') == '3' ? 'selected' : '' }}>Section 3</option>
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

                    <p style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #64748b;">
                        Already have an account?
                        <a href="{{ route('student.login') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Login here</a>
                    </p>
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
    // Clear all input fields on load to prevent browser autofill
    window.addEventListener('load', function () {
        document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"]').forEach(function (input) {
            input.value = '';
        });
    });

    // "Sign up here" link inside login form switches to signup tab
    const goToSignup = document.getElementById('go-to-signup');
    if (goToSignup) {
        goToSignup.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('signup-tab').click();
        });
    }

    // Auto-switch to Sign Up tab if there are validation errors and old input belongs to signup form
    @if ($errors->any() && old('student_id'))
        window.addEventListener('load', function () {
            const signupTab = document.getElementById('signup-tab');
            if (signupTab) signupTab.click();
        });
    @endif
</script>

</body>
</html>