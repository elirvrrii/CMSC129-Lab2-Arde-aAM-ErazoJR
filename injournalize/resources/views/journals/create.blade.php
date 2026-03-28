@extends('layouts.app')

@section('content')
<h1>Add Journal Entry</h1>
<form method="POST" action="{{ route('journals.store') }}">
    @csrf
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        @error('title')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control">{{ old('content') }}</textarea>
        @error('content')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="{{ old('date') }}">
        @error('date')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Mood</label>
        <select name="mood" class="form-control">
            <option value="happy">Happy</option>
            <option value="sad">Sad</option>
            <option value="angry">Angry</option>
            <option value="neutral">Neutral</option>
        </select>
        @error('mood')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>User</label>
        <select name="user_id" class="form-control">
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection