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
        @foreach($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $user->name }}
                <div>
                    <a href="{{ route('users.switch', $user->id) }}" class="btn btn-sm btn-primary">Switch</a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endif
@endsection