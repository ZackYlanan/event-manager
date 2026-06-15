<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="#">
                Event Management System
            </a>

            <div>

                {{-- <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-light me-2">
                Dashboard
            </a>
 --}}
                <a href="{{ route('events.index') }}" class="btn btn-outline-light me-2">
                    Events
                </a>

                <form class="d-inline" method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn btn-danger">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </nav>

    <div class="container mt-4">

        @yield('content')

    </div>

</body>

</html>
