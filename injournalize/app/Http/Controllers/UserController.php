<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'password' => $request->password, // mutator will hash
        ]);

        session(['active_user' => $user->id]);

        return redirect()->route('journals.index')->with('success', 'Profile created successfully!');
    }

    // Switch profile
    public function switch(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->password) {
            if (! $request->filled('password')) {
                return redirect()->route('users.index')
                    ->with('info', "Password required for {$user->name}.");
            }

            if (! Hash::check($request->password, $user->password)) {
                return redirect()->route('users.index')
                    ->with('error', "Incorrect password for {$user->name}.");
            }
        }

        session(['active_user' => $user->id]);

        return redirect()->route('journals.index')->with('success', "Switched to {$user->name}");
    }

    public function destroy(User $user)
    {
        // Permanently delete all journal entries first
        $user->journalEntries()->forceDelete();

        // Delete the user
        $user->forceDelete(); // permanently remove user

        // Remove from session if it was active
        if (session('active_user') == $user->id) {
            session()->forget('active_user');
        }

        return redirect()->route('users.index')->with('success', 'Profile permanently deleted!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'avatar' => 'nullable|image|max:1024',
            'password' => 'nullable|string|min:4',
        ]);

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // update()
        if ($request->filled('password')) {
            $user->password = $request->password; // mutator will hash
        }

        $user->name = $request->name;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Profile updated!');
    }
}
