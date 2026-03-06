<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::withCount('orders')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the user role.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the user's role.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        if (auth()->id() === $user->id && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'You cannot remove your own administrative privileges.');
        }

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }

    /**
     * Remove the user from the system.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
