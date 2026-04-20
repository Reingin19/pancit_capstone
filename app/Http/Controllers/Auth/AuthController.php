<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ============ STUDENT ============
    public function showStudentLoginForm()
    {
        return view('login.student_login');
    }

    public function studentLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();

        // 1. Check ang Role (Dapat student lang ang makakapasok dito)
        if ($user->role !== 'student') {
            Auth::logout();
            return back()->withErrors([
                'email' => "This account is registered as a {$user->role}. Please use the {$user->role} login portal.",
            ]);
        }

        // 2. Check ang Status (Dapat 'approved' ang nasa database status column)
        // Ginamit natin ang 'status' dahil ito ang nasa migration mo, hindi 'is_approved'
        if ($user->status !== 'approved') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account is pending for admin approval.'
            ]);
        }

        // 3. Success! Regenerate session at go sa dashboard
        $request->session()->regenerate();
        return redirect()->route('student.dashboard');
    }

    return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
}
    public function studentRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'is_approved' => false,
        ]);

        // Do NOT auto-login
        return redirect()->route('student.login')
                         ->with('success', 'Account created successfully! Please log in.');
    }

    // ============ TEACHER ============
   public function showTeacherLoginForm()
    {
        return view('login.teacher_login');
    }

    public function teacherLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // 1. Check Role
            if ($user->role !== 'teacher') {
                Auth::logout();
                return back()->withErrors([
                    'email' => "This account is registered as a {$user->role}. Please use the teacher login portal.",
                ]);
            }

            // 2. Check Status (Dapat tugma sa 'approved' sa database)
            if ($user->status !== 'approved') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending for admin approval.'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('teacher.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

    public function showTeacherRegisterForm()
    {
        return view('login.teacher_register');
    }

    public function teacherRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('teacher.login')->with('success', 'Registered! Please wait for admin approval.');
    }

    // ============ ADMIN ============
    public function showAdminLoginForm()
    {
        return view('login.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => "This account is registered as a {$user->role}. Please use the {$user->role} login portal.",
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

    public function adminRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        return redirect()->route('admin.login')
                         ->with('success', 'Account created successfully! Please log in.');
    }
    // Para makita ang listahan ng mga hindi pa approved
    public function pendingUsers() {
        $pending = User::where('is_approved', false)->get();
        return view('admin.verify-users', compact('pending'));
    }

    // Para i-approve ang user
    public function approveUser($id) {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

    return back()->with('success', 'User approved successfully!');
    }


    // ============ LOGOUT ============
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage');
    }

    }
