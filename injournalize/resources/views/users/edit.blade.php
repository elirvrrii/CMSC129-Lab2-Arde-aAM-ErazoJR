@extends('layouts.app')

@section('content')
<h2>Edit Profile</h2>

<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Avatar (optional)</label>
        <input type="file" name="avatar" class="form-control">
        @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" width="80" height="80" class="mt-2 rounded-circle">
        @endif
        @error('avatar')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Password (optional)</label>
        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection