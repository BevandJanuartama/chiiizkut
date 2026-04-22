<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title') - ChiiiZkut Bakery Artisanal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-cream: #FFFCF5;
            --text-brown: #5C3D2E;
            --brand-yellow: #F6AA1C;
            --brand-dark: #8A4117;
            --card-border: #F0E6D2;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-cream);
            color: var(--text-brown);
            overflow-x: hidden;
        }

        .font-serif { font-family: 'Lora', serif; color: var(--brand-dark); }
        .text-brown { color: var(--text-brown); }
        .text-brand-dark { color: var(--brand-dark); }
        .text-brand-yellow { color: var(--brand-yellow); }

        /* Responsive Sidebar */
        .sidebar-artisanal {
            width: 280px;
            min-height: 100vh;
            background-color: #ffffff; 
            border-right: 1px solid var(--card-border);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
        }

        /* Sidebar hidden on mobile */
        @media (max-width: 768px) {
            .sidebar-artisanal {
                transform: translateX(-100%);
                width: 280px;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .sidebar-artisanal.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                width: 100%;
                margin-left: 0 !important;
            }
        }

        /* Sidebar visible on desktop */
        @media (min-width: 769px) {
            .sidebar-artisanal {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 280px;
                width: calc(100% - 280px);
            }
        }

        /* Mobile menu button */
        .mobile-menu-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--brand-yellow);
            border: none;
            border-radius: 12px;
            padding: 0.5rem 0.75rem;
            color: var(--text-brown);
            font-size: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.9rem 1.2rem;
            color: var(--text-brown);
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            margin-bottom: 0.4rem;
            white-space: nowrap;
        }

        /* Responsive nav text */
        @media (max-width: 480px) {
            .nav-link-custom span {
                font-size: 0.9rem;
            }
            
            .nav-link-custom i {
                font-size: 1.1rem;
            }
        }

        .nav-link-custom:hover {
            background-color: #FFF4E0;
            color: var(--brand-dark);
            transform: translateX(5px);
        }

        .nav-link-custom.active {
            background-color: var(--brand-yellow);
            color: var(--text-brown);
            box-shadow: 0 4px 12px rgba(246, 170, 28, 0.2);
        }

        .nav-link-custom i {
            font-size: 1.25rem;
            min-width: 24px;
        }

        .btn-logout {
            background-color: #fff;
            color: #DC3545;
            border: 1px solid #DC3545;
            font-weight: 700;
            border-radius: 14px;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-logout:hover {
            background-color: #DC3545;
            color: #fff;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
            transform: translateY(-2px);
        }

        /* Search Bar Responsive */
        .search-bar {
            border-radius: 50px;
            border: 1px solid var(--card-border);
            padding: 0.6rem 1.5rem;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        
        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
        }

        /* Responsive Cards */
        .card-soft {
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.2s ease;
        }
        
        .card-soft:hover { 
            transform: translateY(-3px); 
        }

        .promo-card-1 {
            background-color: var(--brand-yellow);
            color: var(--text-brown);
            border-radius: 24px;
            border: none;
        }
        
        .promo-card-2 {
            background-color: var(--brand-dark);
            color: #fff;
            border-radius: 24px;
            border: none;
        }

        .btn-promo {
            background: rgba(0,0,0,0.2);
            color: inherit;
            border: none;
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .btn-promo:hover { 
            background: rgba(0,0,0,0.3); 
            color: inherit;
            transform: translateX(5px);
        }

        .icon-box-soft {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 1.5rem;
        }
        
        /* Responsive icon box */
        @media (max-width: 576px) {
            .icon-box-soft {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }
        }
        
        .bg-soft-yellow { background-color: #FFF4E0; color: var(--brand-yellow); }
        .bg-soft-brown { background-color: #F3EBE1; color: var(--brand-dark); }
        .bg-soft-red { background-color: #FFE5E5; color: #DC3545; }

        /* Responsive padding untuk main content */
        @media (max-width: 576px) {
            .main-content {
                padding: 1rem !important;
            }
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--brand-yellow);
            border-radius: 10px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-content {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="bi bi-list fs-3"></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar-artisanal" id="sidebar">
            <div class="text-center mb-4 mb-md-5">
                <a href="{{ route('admin.dashboard') }}" class="d-inline-block text-decoration-none">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo ChiiiZkut" class="img-fluid mb-1" style="max-height: 80px; max-width: 100%; object-fit: contain;">
                </a>
                <p class="text-muted fw-bold text-uppercase mt-2" style="letter-spacing: 2px; font-size: 1.0rem;">
                    Admin Panel
                </p>
            </div>
            
            <nav class="d-flex flex-column flex-grow-1 mt-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('produks.index') }}" class="nav-link-custom {{ request()->is('admin/produk*') || request()->routeIs('produks.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Produk Cake</span>
                </a>

                <a href="{{ route('stok.logs') }}" class="nav-link-custom {{ request()->is('admin/stok/logs') || request()->routeIs('stok.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat Stok</span>
                </a>
            </nav>

            <div class="mt-auto pt-4" style="border-top: 1px solid var(--card-border);">
                <div class="d-flex align-items-center gap-3 mb-4 px-2">
                    <div class="rounded-circle bg-soft-yellow d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-badge-fill text-brand-yellow fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-bold text-brand-dark" style="font-size: 0.85rem;">Administrator</p>
                        <p class="mb-0 text-success fw-semibold" style="font-size: 0.65rem;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem; vertical-align: middle;"></i>Online
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-logout w-100 d-flex justify-content-center align-items-center gap-2 py-2">
                        <i class="bi bi-box-arrow-right fs-5"></i> 
                        <span>LOGOUT</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 main-content p-3 p-md-4 p-lg-5" id="mainContent">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            
            // Function to open sidebar
            function openSidebar() {
                sidebar.classList.add('mobile-open');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            // Function to close sidebar
            function closeSidebar() {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            // Toggle sidebar on mobile menu button click
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (sidebar.classList.contains('mobile-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }
            
            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }
            
            // Close sidebar when clicking a link on mobile
            const navLinks = document.querySelectorAll('.nav-link-custom');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 768) {
                        // On desktop, ensure sidebar is visible and overlay is hidden
                        sidebar.classList.remove('mobile-open');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }, 250);
            });
            
            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                    closeSidebar();
                }
            });
            
            // Prevent body scroll when sidebar is open on mobile
            sidebar.addEventListener('touchmove', function(e) {
                if (window.innerWidth <= 768) {
                    e.stopPropagation();
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>