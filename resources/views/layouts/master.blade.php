<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <nav style="padding: 20px; background-color: #eee;">
        <a href="{{ route('dashboard') }}">Dashboard</a> | 
        <a href="{{ route('events.index') }}">My Events</a> |
        
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </nav>

    <main style="padding: 20px;">
        @yield('content')
    </main>

</body>
</html>