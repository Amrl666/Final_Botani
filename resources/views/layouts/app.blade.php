<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" href="{{ asset('logo/logobotani.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
            --sidebar-width: 230px; /* Even shorter when open */
            --sidebar-collapsed-width: 80px; /* Even more compact for icon-only mode */
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
            overflow-x: hidden; /* Prevent horizontal scroll on body */
            display: flex; /* Use flexbox for main layout */
        }

        /* Page Loading Animation (no changes) */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            animation: logoFloat 2s ease-in-out infinite;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .loader-logo .text-green {
            color: var(--primary-color);
        }

        .loader-logo .text-black {
            color: var(--text-color);
        }

        .loader-text {
            font-size: 1rem;
            color: var(--text-color);
            font-weight: 500;
            text-align: center;
            animation: textPulse 2s ease-in-out infinite;
            margin-bottom: 1.5rem;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .loader-dots {
            display: flex;
            gap: 0.4rem;
        }

        .loader-dot {
            width: 6px;
            height: 6px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: dotBounce 1.4s ease-in-out infinite;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.3);
        }

        .loader-dot:nth-child(1) { animation-delay: 0s; }
        .loader-dot:nth-child(2) { animation-delay: 0.2s; }
        .loader-dot:nth-child(3) { animation-delay: 0.4s; }

        /* Loading Animations (no changes) */
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes textPulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        @keyframes dotBounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Page Transition Effects (no changes) */
        .page-transition {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .page-transition.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* Sidebar Styles */
        #sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            width: var(--sidebar-width); /* Default desktop width */
            position: fixed; /* Fixed on desktop */
            left: 0;
            top: 0;
            z-index: 1000;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* Add transform for mobile slide */
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Enable vertical scrolling for content */
            overflow-x: hidden; /* Hide horizontal scrollbar */
            display: flex;
            flex-direction: column;
        }

        #sidebar.collapsed { /* Desktop collapsed state */
            width: var(--sidebar-collapsed-width);
        }

        /* Sidebar Header */
        #sidebar .sidebar-header {
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
            transition: padding 0.3s ease;
        }
        
        #sidebar.collapsed .sidebar-header { /* Collapsed header padding */
            padding: 1.5rem 0.5rem; /* Reduced padding to fit icon + toggle */
        }

        /* Sidebar Header Logo/Text */
        #sidebar .sidebar-header .logo-text { /* Use a new class for the text */
            color: white;
            font-weight: 700;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: opacity 0.3s ease, max-width 0.3s ease, margin 0.3s ease; /* Transition max-width and margin */
            flex-grow: 1;
            text-align: left;
            max-width: 100%;
        }

        #sidebar.collapsed .sidebar-header .logo-text {
            opacity: 0; /* Hide logo text */
            max-width: 0; /* Shrink width */
            margin: 0; /* Remove margin */
            padding: 0; /* Remove padding */
            line-height: 0; /* Collapse line height */
        }

        /* Sidebar Toggle Button (inside sidebar header) */
        #sidebar .sidebar-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 36px; /* Slightly larger button */
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease; /* Adjusted transition: removed transform to let icon handle it */
            flex-shrink: 0; /* Prevent button from shrinking */
        }

        #sidebar .sidebar-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1); /* This scale effect is for the button itself */
        }
        
        /* Removed transform rotate from here for desktop collapsed state,
           as icon itself will change (bars to times) */


        #sidebar .position-sticky {
            flex-grow: 1;
            overflow-y: auto; /* Enable vertical scrolling for menu items */
            padding-bottom: 1rem; /* Add some padding at the bottom for scroll comfort */
        }

        /* Sidebar Nav Links */
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
            overflow: hidden; /* Hide overflow when text is hidden */
        }

        /* Hover animation for nav links */
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
            width: 20px; /* Fixed width for icons */
            text-align: center;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
            flex-shrink: 0; /* Keep icon from shrinking */
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(8px); /* Slide effect */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #sidebar .nav-link:hover i,
        #sidebar .nav-link.active i {
            transform: scale(1.1); /* Icon scale on hover/active */
        }

        /* Nav link text when sidebar collapsed */
        #sidebar .nav-link span {
            white-space: nowrap;
            transition: opacity 0.3s ease, width 0.3s ease, margin-left 0.3s ease;
            overflow: hidden;
            flex-grow: 1;
            line-height: 1; /* Collapse line height to save vertical space */
        }

        #sidebar.collapsed .nav-link span {
            opacity: 0; /* Hide text */
            width: 0; /* Collapse text width */
            margin-left: -0.875rem; /* Compensate for the gap to center icon */
            line-height: 0;
        }
        
        /* Nav link icon alignment when collapsed */
        #sidebar.collapsed .nav-link {
            padding: 0.875rem 0.5rem; /* Reduced padding for icon-only mode */
            justify-content: center; /* Center the icon */
            margin: 0.25rem 0.25rem; /* Smaller margins */
        }
        
        #sidebar.collapsed .nav-link i {
            margin-right: 0; /* Remove icon margin */
            width: auto; /* Allow icon to take natural width */
        }


        /* Logout button (similar logic to nav links) */
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
            transition: all 0.3s ease; /* Adjusted transition: removed transform */
            margin: 0.25rem 1rem;
            border-radius: 0.75rem;
            white-space: nowrap;
        }

        /* Hover animation for logout button */
        #sidebar .btn-link:hover {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px); /* Slide effect */
        }

        #sidebar .btn-link i {
            width: 20px;
            text-align: center;
        }

        #sidebar.collapsed .btn-link span {
            opacity: 0;
            width: 0;
            margin-left: -0.875rem;
        }

        /* Logout button icon alignment when collapsed */
        #sidebar.collapsed .btn-link {
            padding: 0.875rem 0.5rem;
            justify-content: center;
            margin: 0.25rem 0.25rem;
        }
        #sidebar.collapsed .btn-link i {
            margin-right: 0;
            width: auto;
        }

        /* Main Content Area (no changes) */
        main {
            flex-grow: 1; /* Main content takes remaining space */
            margin-left: var(--sidebar-width); /* Default margin for open sidebar */
            padding: 2rem;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            overflow-x: hidden; /* Prevent horizontal overflow from main content */
        }

        /* Main content margin when sidebar is collapsed */
        body.sidebar-closed main {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Page Header (General styles, no sidebar toggle button here) */
        .page-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideDown 0.6s ease-out;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .page-header h1 {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.875rem;
            flex-shrink: 0;
        }

        .page-header .breadcrumb {
            margin: 0;
            background: none;
            padding: 0;
            flex-grow: 1;
            text-align: left;
        }

        .page-header .breadcrumb-item + .breadcrumb-item::before {
            content: '›';
            color: var(--text-muted);
        }

        /* Alert Styles (no changes) */
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
            border-left: 4px solid #10b981;
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

        /* Card Styles (no changes) */
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

        /* Table Styles (no changes) */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin-bottom: 0;
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
            white-space: nowrap;
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
            white-space: nowrap;
        }

        /* Button Styles (no changes) */
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

        /* Badge Styles (no changes) */
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

        /* Form Styles (no changes) */
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

        /* Animations (no changes) */
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
        /* Desktop/Tablet (min-width: 769px) */
        @media (min-width: 769px) {
            /* Sidebar & Main Content Sizing for Desktop */
            body.sidebar-closed #sidebar {
                width: var(--sidebar-collapsed-width);
            }
            body.sidebar-closed #sidebar .sidebar-header .logo-text {
                opacity: 0;
                max-width: 0; /* Make width 0 so it truly collapses */
                padding: 0;
                margin: 0;
                line-height: 0;
            }
            body.sidebar-closed #sidebar .nav-link span,
            body.sidebar-closed #sidebar .btn-link span {
                opacity: 0;
                width: 0;
                margin-left: -0.875rem; /* Adjust gap */
            }
            body.sidebar-closed #sidebar .nav-link {
                padding: 0.875rem 0.5rem; /* Reduced padding for icon only */
                justify-content: center; /* Center icon */
                margin: 0.25rem 0.25rem; /* Smaller margins */
            }
            body.sidebar-closed #sidebar .btn-link {
                padding: 0.875rem 0.5rem;
                justify-content: center;
                margin: 0.25rem 0.25rem;
            }
            body.sidebar-closed #sidebar .nav-link i,
            body.sidebar-closed #sidebar .btn-link i {
                margin-right: 0; /* Remove icon margin when text hidden */
                width: auto; /* Allow icon to take natural width */
            }
            /* No rotation on desktop toggle if using fa-bars/fa-times */

            body.sidebar-closed main {
                margin-left: var(--sidebar-collapsed-width);
            }

            /* Page Header (Desktop) */
            .page-header {
                padding: 1.5rem 2rem;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .page-header h1 {
                flex-grow: 1;
            }

            .page-header .breadcrumb {
                text-align: left;
            }
        }

        /* Mobile Specific Styles (max-width: 768px) */
        @media (max-width: 768px) {
            body {
                flex-direction: column; /* Stack sidebar and main content vertically */
            }

            #sidebar {
                position: fixed;
                height: 100vh;
                transform: translateX(-100%); /* Hide sidebar off-screen by default */
                width: 100%;
                max-width: var(--sidebar-width); /* Use the open sidebar width as max for mobile */
                box-shadow: 0 0 20px rgba(0,0,0,0.3);
                z-index: 1050;
            }

            #sidebar.show { /* This class is added to show the sidebar (slide in) */
                transform: translateX(0);
            }

            body.sidebar-mobile-open { /* When mobile sidebar is open, prevent body scroll */
                overflow: hidden;
            }

            main {
                margin-left: 0; /* Remove left margin on mobile, main content takes full width */
                padding: 1rem;
            }

            .page-header {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }
            .page-header .breadcrumb {
                margin-top: 0.5rem;
                font-size: 0.9rem;
            }

            /* Overlay when mobile sidebar is open */
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            body.sidebar-mobile-open .overlay {
                display: block;
            }

            /* Adjust sidebar header and toggle button for mobile (always fully open) */
            #sidebar .sidebar-header {
                justify-content: space-between;
                padding: 1rem;
            }
            #sidebar .sidebar-header .logo-text { /* Ensure logo text is visible on mobile */
                opacity: 1;
                max-width: 100%;
                font-size: 1.3rem;
            }
            #sidebar .sidebar-toggle-btn { /* Style for mobile toggle button */
                background: transparent;
                border: 1px solid rgba(255,255,255,0.5);
                width: 32px;
                height: 32px;
                transform: rotate(0deg); /* Reset rotation for mobile icon */
            }
            #sidebar.collapsed .sidebar-toggle-btn { /* No rotation on mobile collapsed state */
                transform: rotate(0deg);
            }

            /* Ensure nav link text is visible on mobile (as sidebar slides out fully) */
            #sidebar .nav-link span,
            #sidebar .btn-link span {
                opacity: 1;
                width: auto;
                margin-left: 0.875rem; /* Restore gap */
            }
            #sidebar .nav-link,
            #sidebar .btn-link {
                justify-content: flex-start; /* Align to start */
                padding-left: 1.5rem; /* Restore padding */
                padding-right: 1.5rem;
                margin-left: 1rem; /* Restore margins */
                margin-right: 1rem;
            }
            #sidebar .nav-link i,
            #sidebar .btn-link i {
                margin-right: 0.875rem; /* Restore icon margin */
            }
        }

        @media (max-width: 576px) {
            main {
                padding: 0.75rem;
            }
            .page-header {
                padding: 0.75rem;
            }
            .page-header h1 {
                font-size: 1.25rem;
            }
            .page-header .breadcrumb {
                font-size: 0.8rem;
            }
            #sidebar .sidebar-header {
                padding: 0.75rem;
            }
            #sidebar .sidebar-header .logo-text {
                font-size: 1.1rem;
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
        /* Custom scrollbar for webkit browsers */
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    
    @stack('styles')
    
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800 lansia-friendly">
    {{-- Page Loading Screen --}}
    <div class="page-loader" id="pageLoader">
        <div class="loader-logo">
            <span class="text-green">BO</span><span class="text-black">TANI</span>
        </div>
        <div class="loader-text">Memuat dashboard...</div>
        <div class="loader-dots">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>
    </div>

    <nav id="sidebar">
        <div class="sidebar-header">
            <span class="logo-text">BO TANI Admin</span>
            <button class="sidebar-toggle-btn" id="sidebarToggleBtn">
                <i class="fas fa-bars"></i> {{-- Default icon is bars --}}
            </button>
        </div>
        
        {{-- This div allows the content inside to scroll independently --}}
        <div class="position-sticky pt-4 px-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
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
                        <span>Galeri</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard.videos.index') }}" class="nav-link {{ request()->routeIs('dashboard.videos.*') ? 'active' : '' }}">
                        <i class="fas fa-video"></i>
                        <span>Video</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard.product.index') }}" class="nav-link {{ request()->routeIs('dashboard.product.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
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
                        <span>Pesanan</span>
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <main class="page-transition" id="mainContent">
        <div class="page-header">
            <h1>@yield('title')</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
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

    <div class="overlay" id="sidebarOverlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Page Loading Management
        let isLoading = false;
        const pageLoader = document.getElementById('pageLoader');
        const mainContent = document.getElementById('mainContent');

        function showLoading() {
            if (isLoading) return;
            isLoading = true;
            pageLoader.classList.remove('hidden');
            mainContent.classList.remove('loaded');
        }

        function hideLoading() {
            isLoading = false;
            pageLoader.classList.add('hidden');
            mainContent.classList.add('loaded');
        }

        // Initial page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                hideLoading();
            }, 500); // Reduced loading time
        });

        // Handle page transitions (for internal links only)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.href.includes('#') && !link.href.includes('javascript:') && !link.target) {
                // Check if it's an internal link
                if (link.href.startsWith(window.location.origin) && !link.href.includes('logout')) {
                    e.preventDefault(); // Prevent default navigation
                    showLoading();
                    
                    // Navigate to the page after a small delay for animation
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 300); 
                }
            }
        });

        // Handle form submissions (show loading)
        document.addEventListener('submit', function(e) {
            // Only show loading for non-GET forms
            if (e.target.method && e.target.method.toLowerCase() !== 'get') {
                showLoading();
            }
        });

        // Handle browser back/forward (show loading)
        window.addEventListener('beforeunload', function() {
            showLoading();
        });


        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn'); // The button INSIDE sidebar header
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        // Function to update sidebar and icon state
        function updateSidebarState(isCollapsed) {
            if (isCollapsed) {
                body.classList.add('sidebar-closed');
                // Desktop: change to times icon (X) when collapsed
                if (window.innerWidth > 768) { 
                    sidebarToggleBtn.querySelector('i').classList.replace('fa-bars', 'fa-times');
                }
            } else {
                body.classList.remove('sidebar-closed');
                // Desktop: change to bars icon when open
                if (window.innerWidth > 768) {
                    sidebarToggleBtn.querySelector('i').classList.replace('fa-times', 'fa-bars');
                }
            }
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }

        // Initialize sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            updateSidebarState(isCollapsed); // Apply the saved state
            handleResize(); // Initial check for mobile view and button visibility
        });

        // Toggle sidebar when the button in the sidebar-header is clicked
        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', function() {
                const isMobile = window.innerWidth <= 768;

                if (isMobile) {
                    // For mobile, toggle the 'show' class on sidebar and 'sidebar-mobile-open' on body
                    sidebar.classList.toggle('show');
                    body.classList.toggle('sidebar-mobile-open');
                    
                    // Toggle icon for mobile (bars vs times)
                    const icon = sidebarToggleBtn.querySelector('i');
                    if (sidebar.classList.contains('show')) {
                        icon.classList.replace('fa-bars', 'fa-times'); // Change to X icon
                    } else {
                        icon.classList.replace('fa-times', 'fa-bars'); // Change to bars icon
                    }
                } else {
                    // For desktop, toggle the 'sidebar-closed' class on body
                    const isCollapsed = body.classList.contains('sidebar-closed');
                    updateSidebarState(!isCollapsed);
                }
            });
        }

        // Close mobile sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                body.classList.remove('sidebar-mobile-open');
                // Reset icon to bars for mobile
                if (window.innerWidth <= 768) {
                    sidebarToggleBtn.querySelector('i').classList.replace('fa-times', 'fa-bars');
                }
                // Desktop icon state will be handled by handleResize or next click
            });
        }
        
        // Also close mobile sidebar if a nav link is clicked
        const navLinks = document.querySelectorAll('#sidebar .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) { // Only for mobile
                    sidebar.classList.remove('show');
                    body.classList.remove('sidebar-mobile-open');
                    sidebarToggleBtn.querySelector('i').classList.replace('fa-times', 'fa-bars'); // Reset icon to bars
                }
            });
        });


        // Handle responsive behavior on window resize
        let isMobileView = window.innerWidth <= 768; // Initial check

        function handleResize() {
            const currentIsMobileView = window.innerWidth <= 768;

            if (currentIsMobileView !== isMobileView) {
                // If transitioning between desktop and mobile view
                if (currentIsMobileView) {
                    // Desktop to mobile:
                    // Force desktop sidebar state to 'open' conceptually (margin-left adjusts)
                    updateSidebarState(false); 
                    body.classList.remove('sidebar-mobile-open'); // Ensure overlay is off
                    sidebar.classList.remove('show'); // Ensure mobile sidebar is initially hidden
                    // Set mobile default icon to bars
                    sidebarToggleBtn.querySelector('i').classList.remove('fa-times'); // Remove times if present
                    sidebarToggleBtn.querySelector('i').classList.add('fa-bars');
                } else {
                    // Mobile to desktop: Restore desktop state (collapsed or open)
                    const desktopCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    updateSidebarState(desktopCollapsed); // Apply desktop state
                    body.classList.remove('sidebar-mobile-open'); // Ensure overlay is off
                    sidebar.classList.remove('show'); // Ensure mobile sidebar is hidden
                    // Restore desktop icon based on desktop state
                    const icon = sidebarToggleBtn.querySelector('i');
                    if (body.classList.contains('sidebar-closed')) {
                        icon.classList.replace('fa-bars', 'fa-times');
                    } else {
                        icon.classList.replace('fa-times', 'fa-bars');
                    }
                }
                isMobileView = currentIsMobileView; // Update mobile view state
            }
        }

        window.addEventListener('resize', handleResize);


        // Handle AJAX requests (if any) - ensure jQuery is loaded for this to work
        if (typeof jQuery !== 'undefined') { // Changed from $ to jQuery
            jQuery(document).ajaxStart(function() {
                showLoading();
            });
            
            jQuery(document).ajaxStop(function() {
                hideLoading();
            });
        }

        // Add loading animation to specific elements (optional, for partial updates)
        function addLoadingToElement(element) {
            element.classList.add('loading');
        }

        function removeLoadingFromElement(element) {
            element.classList.remove('loading');
        }
    </script>
    
    @stack('scripts')
</body>
</html>