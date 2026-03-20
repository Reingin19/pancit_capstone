<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>
    <h1>Register as Student</h1>

    {{-- Success message --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('student.register') }}">
        @csrf

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required><br>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required><br>

        <label>Password</label>
        <input type="password" name="password" required><br>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('student.login') }}">Login here</a></p>
</body>
</html>
