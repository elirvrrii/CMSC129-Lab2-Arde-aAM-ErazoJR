<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index() {
    $activeUserId = session('active_user');

    // Redirect if no users exist
    if (!User::count()) {
        return redirect()->route('users.create')->with('info', 'Please create a profile first.');
    }

    // Redirect if no active profile selected
    if (!$activeUserId) {
        return redirect()->route('users.index')->with('info', 'Please select a profile.');
    }

    $journals = JournalEntry::where('user_id', $activeUserId)
        ->orderBy('date','desc')
        ->get();

    $trashedJournals = JournalEntry::onlyTrashed()
        ->where('user_id', $activeUserId)
        ->orderBy('deleted_at','desc')
        ->get();

    return view('journals.index', compact('journals','trashedJournals'));
    }

    public function create()
    {
        $users = User::all();
        return view('journals.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'date' => 'required|date',
            'mood' => 'required|string',
        ]);

        JournalEntry::create($request->all());
        return redirect()->route('journals.index')->with('success','Journal added!');
    }

    public function edit(JournalEntry $journal)
    {
        $users = User::all();
        return view('journals.edit', compact('journal','users'));
    }

    public function update(Request $request, JournalEntry $journal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'date' => 'required|date',
            'mood' => 'required|string',
        ]);

        $journal->update($request->all());
        return redirect()->route('journals.index')->with('success','Journal updated!');
    }

    public function destroy(JournalEntry $journal)
    {
        $journal->delete();
        return redirect()->route('journals.index')->with('success','Journal soft deleted!');
    }

    public function restore($id)
    {
        $journal = JournalEntry::onlyTrashed()->findOrFail($id);
        $journal->restore();
        return redirect()->route('journals.index')->with('success','Journal restored!');
    }

    public function hardDelete($id)
    {
        $journal = JournalEntry::onlyTrashed()->findOrFail($id);
        $journal->forceDelete();
        return redirect()->route('journals.index')->with('success','Journal permanently deleted!');
    }
}