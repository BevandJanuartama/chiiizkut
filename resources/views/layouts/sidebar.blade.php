{{-- <style>
    /* CSS Khusus Sidebar Artisanal */
    .sidebar-artisanal {
        width: 280px;
        min-height: 100vh;
        background-color: #ffffff; 
        border-right: 1px solid var(--card-border);
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        padding: 2rem 1.5rem;
        z-index: 1000;
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
    }

    .nav-link-custom:hover {
        background-color: #FFF4E0; /* Soft yellow hover */
        color: var(--brand-dark);
    }

    .nav-link-custom.active {
        background-color: var(--brand-yellow);
        color: var(--text-brown);
        box-shadow: 0 4px 12px rgba(246, 170, 28, 0.2);
    }

    .nav-link-custom i {
        font-size: 1.25rem;
    }

    .btn-logout {
        background-color: #fff;
        color: #DC3545;
        border: 1px solid #DC3545;
        font-weight: 700;
        border-radius: 14px;
        transition: all 0.2s;
    }

    .btn-logout:hover {
        background-color: #DC3545;
        color: #fff;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
    }
</style>

<aside class="sidebar-artisanal">
    <div class="text-center mb-5">
        <a href="{{ route('admin.dashboard') }}" class="d-inline-block text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="Logo ChiiiZkut" class="img-fluid mb-1" style="max-height: 70px; object-fit: contain;">
        </a>
        <p class="text-muted fw-bold text-uppercase mt-2" style="letter-spacing: 2px; font-size: 0.65rem;">
            Admin Panel
        </p>
    </div>
    
    <nav class="d-flex flex-column flex-grow-1 mt-2">
        <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('produks.index') }}" class="nav-link-custom {{ request()->is('admin/produk*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Produk Cake</span>
        </a>

        <a href="{{ route('stok.logs') }}" class="nav-link-custom {{ request()->is('admin/stok/logs') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Stok</span>
        </a>
    </nav>

    <div class="mt-auto pt-4" style="border-top: 1px solid var(--card-border);">
        
        <div class="d-flex align-items-center gap-3 mb-4 px-2">
            <div class="rounded-circle bg-soft-yellow d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-person-badge-fill text-brand-yellow fs-5"></i>
            </div>
            <div>
                <p class="mb-0 fw-bold text-brand-dark" style="font-size: 0.9rem;">Administrator</p>
                <p class="mb-0 text-success fw-semibold" style="font-size: 0.7rem;">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem; vertical-align: middle;"></i>Online
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-logout w-100 d-flex justify-content-center align-items-center gap-2 py-2">
                <i class="bi bi-box-arrow-right fs-5"></i> LOGOUT
            </button>
        </form>
    </div>
</aside> --}}