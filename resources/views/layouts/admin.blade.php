
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel') | UrbanNest Realty</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #1e293b;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 15px;
            border-radius: 6px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #334155;
            color: #ffffff;
        }

        .main-content {
            min-width: 0;
        }

        .brand {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <aside class="sidebar p-3">

        <div class="brand mb-4">
            <i class="bi bi-buildings me-2"></i>
            UrbanNest Realty
        </div>

        <div class="text-uppercase text-secondary small mb-2">
            Main Menu
        </div>

        <nav class="nav flex-column gap-2">

            <a href="{{ route('admin.properties.index') }}"
               class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i>
                Properties
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-people me-2"></i>
                Agents
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-tags me-2"></i>
                Categories
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-file-earmark-text me-2"></i>
                Documents
            </a>

        </nav>

    </aside>

    <!-- Main Content -->
    <div class="flex-grow-1 main-content">

        <!-- Navbar -->
        <nav class="navbar bg-white border-bottom px-4 py-3">

            <span class="navbar-brand fw-semibold">
                @yield('page-heading', 'Dashboard')
            </span>

            <span class="text-secondary">
                <i class="bi bi-person-circle me-1"></i>
                Staff Panel
            </span>

        </nav>

        <!-- Page Content -->
        <main class="p-4">

            @yield('content')

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

@stack('scripts')

</body>
</html>
