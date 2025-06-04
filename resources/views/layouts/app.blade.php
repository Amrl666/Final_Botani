<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <style>
    body {
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    #sidebar {
      min-height: 100vh;
      background-color: #212529;
    }

    #sidebar .nav-link {
      color: #adb5bd;
      font-weight: 500;
      transition: background-color 0.2s, color 0.2s;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      background-color: #495057;
      color: #fff;
      border-radius: 0.375rem;
    }

    #sidebar .btn-link {
      color: #adb5bd;
      padding-left: 1rem;
      text-align: left;
      width: 100%;
      border: none;
    }

    #sidebar .btn-link:hover {
      color: #fff;
      text-decoration: none;
    }

    main {
      padding-top: 2rem;
    }

    .alert {
      margin-top: 1rem;
    }
  </style>
  
  @stack('styles')
</head>
<body>
  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block collapse sidebar">
        <div class="position-sticky pt-4 px-3">
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.blog.index') }}" class="nav-link {{ request()->routeIs('dashboard.blog.*') ? 'active' : '' }}">
                Blog
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.prestasi.index') }}" class="nav-link {{ request()->routeIs('dashboard.prestasi.*') ? 'active' : '' }}">
                Prestasi
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.gallery.index') }}" class="nav-link {{ request()->routeIs('dashboard.gallery.*') ? 'active' : '' }}">
                Gallery
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.videos.index') }}" class="nav-link {{ request()->routeIs('dashboard.videos.*') ? 'active' : '' }}">
                Videos
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.product.index') }}" class="nav-link {{ request()->routeIs('dashboard.product.*') ? 'active' : '' }}">
                Products
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.eduwisata.index') }}" class="nav-link {{ request()->routeIs('dashboard.eduwisata.*') ? 'active' : '' }}">
                Eduwisata
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.contact.messages') }}" class="nav-link {{ request()->routeIs('dashboard.contact.messages') ? 'active' : '' }}">
                Pesan
              </a>
            </li>
            <li class="nav-item mt-4">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link p-0" style="width: 100%; text-align: left;">
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
          <h1 class="h2">@yield('title')</h1>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
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
