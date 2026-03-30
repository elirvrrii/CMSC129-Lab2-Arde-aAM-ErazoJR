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
            <option value="happy" {{ old('mood') == 'happy' ? 'selected' : '' }}>Happy</option>
            <option value="sad" {{ old('mood') == 'sad' ? 'selected' : '' }}>Sad</option>
            <option value="angry" {{ old('mood') == 'angry' ? 'selected' : '' }}>Angry</option>
            <option value="neutral" {{ old('mood') == 'neutral' ? 'selected' : '' }}>Neutral</option>
        </select>
        @error('mood')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <!-- No need for user selection, user_id comes from session -->

    <button class="btn btn-success">Save</button>
</form>
@endsection