<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ChiiiZkut Bakery Artisanal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Bakery Color Palette */
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
        }

        /* Typography */
        .font-serif { font-family: 'Lora', serif; color: var(--brand-dark); }
        .text-brown { color: var(--text-brown); }
        .text-brand-dark { color: var(--brand-dark); }
        .text-brand-yellow { color: var(--brand-yellow); }

        /* Custom UI Elements */
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

        /* Cards */
        .card-soft {
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.2s ease;
        }
        .card-soft:hover { transform: translateY(-3px); }

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
        .btn-promo:hover { background: rgba(0,0,0,0.3); color: inherit; }

        /* Icon Box */
        .icon-box-soft {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 1.5rem;
        }
        
        .bg-soft-yellow { background-color: #FFF4E0; color: var(--brand-yellow); }
        .bg-soft-brown { background-color: #F3EBE1; color: var(--brand-dark); }
        .bg-soft-red { background-color: #FFE5E5; color: #DC3545; }
    </style>
</head>
<body>
    <div class="d-flex">
        @include('layouts.sidebar')

        <main class="flex-grow-1 p-4 p-md-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>