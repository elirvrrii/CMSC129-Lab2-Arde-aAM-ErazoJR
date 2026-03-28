@extends('layouts.app')

@section('content')
<h2>My Journals</h2>

<!-- Success / Info Messages -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<!-- Active Journals -->
<h4>Active Journals</h4>
@if($journals->isEmpty())
    <p>No journals yet.</p>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Mood</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($journals as $journal)
        <tr>
            <td>{{ $journal->title }}</td>
            <td>{{ \Carbon\Carbon::parse($journal->date)->format('Y-m-d') }}</td>
            <td>
                <span class="badge" 
                      style="background-color: {{ $journal->mood_color ?? '#ccc' }}">
                      {{ ucfirst($journal->mood) }}
                </span>
            </td>
            <td>
                <a href="{{ route('journals.edit', $journal->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" 
                            onclick="return confirm('Soft delete this journal?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif

<!-- Trashed Journals -->
<h4>Trash / Archived Journals</h4>
@if($trashedJournals->isEmpty())
    <p>No trashed journals.</p>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Mood</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($trashedJournals as $journal)
        <tr>
            <td>{{ $journal->title }}</td>
            <td>{{ \Carbon\Carbon::parse($journal->date)->format('Y-m-d') }}</td>
            <td>
                <span class="badge" 
                      style="background-color: {{ $journal->mood_color ?? '#ccc' }}">
                      {{ ucfirst($journal->mood) }}
                </span>
            </td>
            <td>
                <!-- Restore -->
                <form action="{{ route('journals.restore', $journal->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                </form>

                <!-- Hard Delete -->
                <form action="{{ route('journals.hardDelete', $journal->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" 
                            onclick="return confirm('Permanently delete this journal?')">Delete Permanently</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif

<a href="{{ route('journals.create') }}" class="btn btn-primary mt-3">Add New Journal</a>
@endsection