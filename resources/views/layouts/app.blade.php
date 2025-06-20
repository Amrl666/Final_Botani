<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>
  <link rel="icon" href="{{ asset('logo/logobotani.png') }}">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #059669;
      --primary-dark: #047857;
      --secondary-color: #10b981;
      --accent-color: #34d399;
      --text-color: #1f2937;
      --text-muted: #6b7280;
      --bg-light: #f8fafc;
      --border-color: #e5e7eb;
      --sidebar-width: 280px;
      --sidebar-collapsed-width: 70px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
      font-family: 'Inter', sans-serif;
      color: var(--text-color);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      overflow-x: hidden;
    }

    /* Sidebar Styles */
    #sidebar {
      min-height: 100vh;
      background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      width: var(--sidebar-width);
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
      overflow-x: hidden;
    }

    #sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }

    #sidebar .sidebar-header {
      padding: 1.5rem;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
    }

    #sidebar .sidebar-header h4 {
      color: white;
      font-weight: 700;
      margin: 0;
      transition: opacity 0.3s ease;
    }

    #sidebar.collapsed .sidebar-header h4 {
      opacity: 0;
    }

    #sidebar .sidebar-toggle {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: white;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    #sidebar .sidebar-toggle:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-50%) scale(1.1);
    }

    #sidebar .nav-link {
      color: rgba(255, 255, 255, 0.8);
      font-weight: 500;
      padding: 0.875rem 1.5rem;
      margin: 0.25rem 1rem;
      border-radius: 0.75rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      align-items: center;
      gap: 0.875rem;
      text-decoration: none;
      position: relative;
      overflow: hidden;
    }

    #sidebar .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.5s ease;
    }

    #sidebar .nav-link:hover::before {
      left: 100%;
    }

    #sidebar .nav-link i {
      width: 20px;
      text-align: center;
      font-size: 1.1rem;
      transition: transform 0.3s ease;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      transform: translateX(8px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    #sidebar .nav-link:hover i,
    #sidebar .nav-link.active i {
      transform: scale(1.1);
    }

    #sidebar .nav-link span {
      transition: opacity 0.3s ease;
    }

    #sidebar.collapsed .nav-link span {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }

    #sidebar .btn-link {
      color: rgba(255, 255, 255, 0.8);
      padding: 0.875rem 1.5rem;
      text-align: left;
      width: 100%;
      border: none;
      display: flex;
      align-items: center;
      gap: 0.875rem;
      background: none;
      transition: all 0.3s ease;
      margin: 0.25rem 1rem;
      border-radius: 0.75rem;
    }

    #sidebar .btn-link:hover {
      color: white;
      text-decoration: none;
      background: rgba(255, 255, 255, 0.15);
      transform: translateX(8px);
    }

    #sidebar .btn-link i {
      width: 20px;
      text-align: center;
    }

    /* Main Content */
    main {
      margin-left: var(--sidebar-width);
      padding: 2rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      min-height: 100vh;
    }

    main.expanded {
      margin-left: var(--sidebar-collapsed-width);
    }

    /* Page Header */
    .page-header {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      animation: slideDown 0.6s ease-out;
    }

    .page-header h1 {
      margin: 0;
      font-weight: 700;
      color: var(--primary-color);
      font-size: 1.875rem;
    }

    .page-header .breadcrumb {
      margin: 0.5rem 0 0 0;
      background: none;
      padding: 0;
    }

    .page-header .breadcrumb-item + .breadcrumb-item::before {
      content: '›';
      color: var(--text-muted);
    }

    /* Alert Styles */
    .alert {
      margin-top: 1rem;
      border-radius: 0.75rem;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      animation: slideDown 0.5s ease-out;
    }

    .alert-success {
      background: linear-gradient(135deg, #d1fae5, #a7f3d0);
      color: #065f46;
      border-left: 4px solid var(--success-color);
    }

    .alert-danger {
      background: linear-gradient(135deg, #fee2e2, #fecaca);
      color: #991b1b;
      border-left: 4px solid #dc2626;
    }

    .alert-warning {
      background: linear-gradient(135deg, #fef3c7, #fde68a);
      color: #92400e;
      border-left: 4px solid #f59e0b;
    }

    .alert-info {
      background: linear-gradient(135deg, #dbeafe, #bfdbfe);
      color: #1e40af;
      border-left: 4px solid #3b82f6;
    }

    /* Card Styles */
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background: rgba(255, 255, 255, 0.8);
      border-bottom: 1px solid var(--border-color);
      padding: 1.5rem;
      font-weight: 600;
      color: var(--primary-color);
    }

    .card-body {
      padding: 1.5rem;
    }

    /* Table Styles */
    .table {
      background: white;
      border-radius: 0.75rem;
      overflow: hidden;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      font-weight: 600;
      border: none;
      padding: 1rem;
      text-transform: uppercase;
      font-size: 0.875rem;
      letter-spacing: 0.05em;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background: rgba(5, 150, 105, 0.05);
      transform: scale(1.01);
    }

    .table tbody td {
      padding: 1rem;
      border-bottom: 1px solid var(--border-color);
      vertical-align: middle;
    }

    /* Button Styles */
    .btn {
      border-radius: 0.5rem;
      padding: 0.625rem 1.25rem;
      font-weight: 500;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(5, 150, 105, 0.3);
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981, #34d399);
      color: white;
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #059669, #10b981);
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-danger {
      background: linear-gradient(135deg, #ef4444, #f87171);
      color: white;
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #dc2626, #ef4444);
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
    }

    .btn-outline-primary {
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      background: transparent;
    }

    .btn-outline-primary:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
    }

    /* Badge Styles */
    .badge {
      padding: 0.5rem 0.75rem;
      border-radius: 0.5rem;
      font-weight: 500;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .bg-primary {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
    }

    .bg-success {
      background: linear-gradient(135deg, #10b981, #34d399) !important;
    }

    .bg-warning {
      background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;
    }

    .bg-danger {
      background: linear-gradient(135deg, #ef4444, #f87171) !important;
    }

    /* Form Styles */
    .form-control {
      border: 2px solid var(--border-color);
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.8);
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
      background: white;
    }

    .form-label {
      font-weight: 500;
      color: var(--text-color);
      margin-bottom: 0.5rem;
    }

    /* Animations */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes scaleIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .animate-fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }

    .animate-slide-up {
      animation: slideUp 0.6s ease-out forwards;
    }

    .animate-scale-in {
      animation: scaleIn 0.6s ease-out forwards;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      #sidebar {
        transform: translateX(-100%);
        width: 100%;
        max-width: 300px;
      }

      #sidebar.show {
        transform: translateX(0);
      }

      main {
        margin-left: 0;
        padding: 1rem;
      }

      .page-header {
        padding: 1.5rem;
      }

      .page-header h1 {
        font-size: 1.5rem;
      }
    }

    /* Loading States */
    .loading {
      position: relative;
      pointer-events: none;
    }

    .loading::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 1rem;
      height: 1rem;
      margin: -0.5rem 0 0 -0.5rem;
      border: 2px solid transparent;
      border-top: 2px solid currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Scrollbar Styling */
    #sidebar::-webkit-scrollbar {
      width: 6px;
    }

    #sidebar::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
    }

    #sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 3px;
    }

    #sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.5);
    }

    /* Focus styles for accessibility */
    .nav-link:focus,
    .btn:focus,
    .form-control:focus {
      outline: 2px solid var(--primary-color);
      outline-offset: 2px;
    }
  </style>
  
  @stack('styles')
</head>
<body>
  <div class="container-fluid p-0">
    <div class="row g-0">
      <!-- Sidebar -->
      <nav id="sidebar">
        <div class="sidebar-header">
          <h4>Botani Admin</h4>
          <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
          </button>
        </div>
        
        <div class="position-sticky pt-4 px-3">
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.blog.index') }}" class="nav-link {{ request()->routeIs('dashboard.blog.*') ? 'active' : '' }}">
                <i class="fas fa-blog"></i>
                <span>Blog</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.prestasi.index') }}" class="nav-link {{ request()->routeIs('dashboard.prestasi.*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i>
                <span>Prestasi</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.gallery.index') }}" class="nav-link {{ request()->routeIs('dashboard.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i>
                <span>Gallery</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.videos.index') }}" class="nav-link {{ request()->routeIs('dashboard.videos.*') ? 'active' : '' }}">
                <i class="fas fa-video"></i>
                <span>Videos</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.product.index') }}" class="nav-link {{ request()->routeIs('dashboard.product.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.eduwisata.index') }}" class="nav-link {{ request()->routeIs('dashboard.eduwisata.*') ? 'active' : '' }}">
                <i class="fas fa-school"></i>
                <span>Eduwisata</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.contact.messages') }}" class="nav-link {{ request()->routeIs('dashboard.contact.messages') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Pesan</span>
              </a>
            </li>
            <li class="nav-item mb-2">
              <a href="{{ route('dashboard.orders.index') }}" class="nav-link {{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
              </a>
            </li>
            <li class="nav-item mt-4">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-link">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Logout</span>
                </button>
              </form>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main content -->
      <main id="main-content">
        <div class="page-header">
          <h1>@yield('title')</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
          </nav>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('warning'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('info'))
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Sidebar toggle functionality
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main-content');
      const toggleBtn = document.querySelector('.sidebar-toggle i');
      
      sidebar.classList.toggle('collapsed');
      main.classList.toggle('expanded');
      
      if (sidebar.classList.contains('collapsed')) {
        toggleBtn.classList.remove('fa-bars');
        toggleBtn.classList.add('fa-chevron-right');
      } else {
        toggleBtn.classList.remove('fa-chevron-right');
        toggleBtn.classList.add('fa-bars');
      }
      
      // Save state to localStorage
      localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    }

    // Mobile sidebar toggle
    function toggleMobileSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('show');
    }

    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main-content');
      const toggleBtn = document.querySelector('.sidebar-toggle i');
      
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      
      if (isCollapsed) {
        sidebar.classList.add('collapsed');
        main.classList.add('expanded');
        toggleBtn.classList.remove('fa-bars');
        toggleBtn.classList.add('fa-chevron-right');
      }
    });

    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(event) {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.querySelector('.sidebar-toggle');
      
      if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
          sidebar.classList.remove('show');
        }
      }
    });

    // Add loading states to forms
    document.addEventListener('DOMContentLoaded', function() {
      const forms = document.querySelectorAll('form');
      forms.forEach(form => {
        form.addEventListener('submit', function() {
          const submitBtn = this.querySelector('button[type="submit"]');
          if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
          }
        });
      });

      // Auto-hide alerts after 5 seconds
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          alert.style.opacity = '0';
          setTimeout(() => {
            alert.remove();
          }, 300);
        }, 5000);
      });

      // Add hover effects to cards
      const cards = document.querySelectorAll('.card');
      cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Add page transition effects
    window.addEventListener('beforeunload', function() {
      document.body.style.opacity = '0';
    });

    window.addEventListener('load', function() {
      document.body.style.opacity = '1';
    });
  </script>
  
  @stack('scripts')
</body>
</html>