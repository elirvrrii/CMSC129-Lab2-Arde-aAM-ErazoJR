<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // only active users, no soft deletes
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'avatar' => 'nullable|image|max:1024',
            'password' => 'nullable|string|min:4',
        ]);

        $user = User::create([
            'name' => $request->name,
            'avatar' => $request->hasFile('avatar') ? $request->file('avatar')->store('avatars', 'public') : null,
            'password' => $request->password ? bcrypt($request->password) : null,
        ]);

        // Set as active user
        session(['active_user' => $user->id]);

        return redirect()->route('journals.index')->with('success', 'Profile created successfully!');
    }

    // Switch profile
    public function switch($id)
    {
        $user = User::findOrFail($id);
        session(['active_user' => $user->id]);
        return redirect()->route('journals.index')->with('success', "Switched to {$user->name}");
    }

    // Hard delete profile
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Remove session if deleted user was active
        if (session('active_user') == $user->id) {
            session()->forget('active_user');
        }

        return redirect()->route('users.index')->with('success', 'Profile deleted!');
    }
}