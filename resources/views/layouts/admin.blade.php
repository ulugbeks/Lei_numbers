<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/backend') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/backend/contacts') }}"><i class="fas fa-envelope"></i> Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.blogs') }}">
                        <i class="fas fa-newspaper"></i> Blogs
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/backend') }}" class="brand-link">
                <span class="brand-text font-weight-light">Admin Panel</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <li class="nav-item">
                            <a href="{{ url('/backend') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/backend/contacts') }}" class="nav-link">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Contacts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/backend/blogs') }}" class="nav-link">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>Blogs</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close">х</button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    <!-- AdminLTE JS -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
