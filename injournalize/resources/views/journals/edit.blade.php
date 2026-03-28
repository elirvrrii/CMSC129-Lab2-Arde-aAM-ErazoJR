@extends('layouts.app')

@section('content')
<h2>Edit Journal Entry</h2>

<form action="{{ route('journals.update', $journal->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title', $journal->title) }}" class="form-control" required>
        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="5" required>{{ old('content', $journal->content) }}</textarea>
        @error('content') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" name="date" value="{{ old('date', $journal->date->format('Y-m-d')) }}" class="form-control" required>
        @error('date') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="mood" class="form-label">Mood</label>
        <select name="mood" class="form-control" required>
            @foreach(['happy','neutral','sad'] as $mood)
                <option value="{{ $mood }}" @if(old('mood', $journal->mood) == $mood) selected @endif>{{ ucfirst($mood) }}</option>
            @endforeach
        </select>
        @error('mood') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Journal</button>
    <a href="{{ route('journals.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection