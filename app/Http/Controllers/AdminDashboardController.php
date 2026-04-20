<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Kunin lahat ng users para sa JS dashboard mo
        $allUsers = User::all(); 
        return view('dashboard.admin_dashboard', compact('allUsers'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        
        // TAMA: Gamitin ang 'approved' dahil ito ang nasa migration mo
        $user->status = 'approved'; 
        
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'User approved successfully!'
        ]);
    }
}