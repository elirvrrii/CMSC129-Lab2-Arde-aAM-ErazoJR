@extends('layouts.app')

@section('content')
<h2>Profiles</h2>

<div class="mb-3">
    <a href="{{ route('users.create') }}" class="btn btn-success">Create New Profile</a>
</div>

@if($users->isEmpty())
    <p>No profiles yet. Please create one above.</p>
@else
    <ul class="list-group">
        @foreach ($users as $user)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                         alt="{{ $user->name }}" class="rounded-circle me-2" width="50" height="50">
                    <span>{{ $user->name }}</span>
                </div>

                <div class="d-flex align-items-center">
                    <!-- Switch Form -->
                    <form method="POST" action="{{ route('users.switch', $user->id) }}" class="me-2">
                        @csrf
                        @if ($user->password)
                            <input type="password" name="password" placeholder="Enter password" required class="form-control form-control-sm me-2">
                        @else
                            <input type="hidden" name="password" value="">
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm">Switch</button>
                    </form>

                    <!-- Edit -->
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>

                    <!-- Soft Delete -->
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Delete this profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endif
@endsection