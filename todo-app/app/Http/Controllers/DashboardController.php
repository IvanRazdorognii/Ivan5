<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    // Show the dashboard
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to access the dashboard.');
        }

        $user = Auth::user();

        return view('dashboard', compact('user'));
    }

    // Show another user's dashboard (Admins only)
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to access the dashboard.');
        }

        $currentUser = Auth::user();

        if ($currentUser->role === 'admin' || $currentUser->id == $id) {
            $user = User::findOrFail($id);

            return view('dashboard', compact('user'));
        } else {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view that page.');
        }
    }
}