@extends('layouts.app')

@section('content')
<h2>Create Your Profile</h2>

@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Avatar (optional)</label>
        <input type="file" name="avatar" class="form-control">
        @error('avatar')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Password (optional)</label>
        <input type="password" name="password" class="form-control">
        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Create Profile</button>
</form>
@endsection