<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    @auth
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('IndexRequest')}}">RequestFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="{{route('IndexRequest')}}">Request</a>
                    <a class="nav-link" href="#">Category</a>
                    <a class="nav-link" href="#">User</a>

                </div>
                <div class="ms-auto">
                    <div class="dropdown">

                        <button
                            class="btn btn-outline-secondary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <span class="dropdown-item-text">
                                    <strong>{{ Auth::user()->name }}</strong>
                                </span>
                            </li>

                            <li>
                                <span class="dropdown-item-text">
                                    {{ Auth::user()->email }}
                                </span>
                            </li>

                            <li>
                                <span class="dropdown-item-text">
                                    Role: {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('Logout') }}" method="POST">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </nav>
    @endauth
    <div class="container mt-3"> 
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>