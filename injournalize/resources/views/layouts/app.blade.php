<!DOCTYPE html>
<html>
<head>
    <title>InJournalize</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <nav class="mb-3">
        <a href="{{ route('journals.index') }}" class="btn btn-primary">Journals</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Switch Profile</a>
    </nav>

    @yield('content')
</div>
</body>
</html>