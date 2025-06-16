<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #2C3E50;
      --secondary-color: #34495E;
      --accent-color: #3498DB;
      --text-color: #2C3E50;
      --sidebar-width: 280px;
    }

    body {
      min-height: 100vh;
      background-color: #F8FAFC;
      font-family: 'Inter', sans-serif;
      color: var(--text-color);
    }

    #sidebar {
      min-height: 100vh;
      background: var(--primary-color);
      width: var(--sidebar-width);
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      transition: all 0.3s ease;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
    }

    #sidebar .nav-link {
      color: #E2E8F0;
      font-weight: 500;
      padding: 0.8rem 1.5rem;
      margin: 0.2rem 1rem;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    #sidebar .nav-link i {
      width: 20px;
      text-align: center;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      background-color: var(--accent-color);
      color: #fff;
      transform: translateX(5px);
    }

    #sidebar .btn-link {
      color: #E2E8F0;
      padding: 0.8rem 1.5rem;
      text-align: left;
      width: 100%;
      border: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    #sidebar .btn-link:hover {
      color: #fff;
      text-decoration: none;
      background-color: var(--accent-color);
      border-radius: 0.5rem;
    }

    main {
      margin-left: var(--sidebar-width);
      padding: 2rem;
      transition: all 0.3s ease;
    }

    .alert {
      margin-top: 1rem;
      border-radius: 0.5rem;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-header {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
    }

    .page-header h1 {
      margin: 0;
      font-weight: 600;
      color: var(--primary-color);
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
      background: white;
      border-radius: 1rem;
      overflow: hidden;
    }

    .table thead th {
      background: var(--primary-color);
      color: white;
      font-weight: 500;
      border: none;
    }

    .btn {
      border-radius: 0.5rem;
      padding: 0.5rem 1rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: var(--accent-color);
      border: none;
    }

    .btn-primary:hover {
      background: var(--secondary-color);
      transform: translateY(-2px);
    }
  </style>
  
  @stack('styles')
</head>
<body>
  <div class="container-fluid p-0">
    <div class="row g-0">
      <!-- Sidebar -->
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block">
        <div class="position-sticky pt-4 px-3">
          <div class="text-center mb-4">
            <h4 class="text-white">Botani Admin</h4>
          </div>
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.blog.index') }}" class="nav-link {{ request()->routeIs('dashboard.blog.*') ? 'active' : '' }}">
                <i class="fas fa-blog"></i> Blog
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.prestasi.index') }}" class="nav-link {{ request()->routeIs('dashboard.prestasi.*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i> Prestasi
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.gallery.index') }}" class="nav-link {{ request()->routeIs('dashboard.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Gallery
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.videos.index') }}" class="nav-link {{ request()->routeIs('dashboard.videos.*') ? 'active' : '' }}">
                <i class="fas fa-video"></i> Videos
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.product.index') }}" class="nav-link {{ request()->routeIs('dashboard.product.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Products
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.eduwisata.index') }}" class="nav-link {{ request()->routeIs('dashboard.eduwisata.*') ? 'active' : '' }}">
                <i class="fas fa-school"></i> Eduwisata
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.contact.messages') }}" class="nav-link {{ request()->routeIs('dashboard.contact.messages') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Pesan
              </a>
            </li>
            <li class="nav-item mt-4">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main content -->
      <main class="col-md-9 ms-sm-auto col-lg-10">
        <div class="page-header">
          <h1>@yield('title')</h1>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
