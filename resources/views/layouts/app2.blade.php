<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ChiiiZkut - Self Ordering Kiosk')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #ffffff;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        
        .bg-chiiiz { background-color: #F2AF17 !important; }
        .text-chiiiz { color: #F2AF17 !important; }
        
        .kiosk-container { 
            background-color: #ffffff; 
            height: 100vh; 
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .product-card { 
            border: 1px solid rgba(0,0,0,0.05); 
            border-radius: 20px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03); 
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            background: #ffffff;
            position: relative;
        }
        .product-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 25px rgba(0,0,0,0.08); 
        }
        .img-wrapper { overflow: hidden; border-top-left-radius: 20px; border-top-right-radius: 20px; position: relative; }
        .product-img { height: 150px; object-fit: cover; width: 100%; transition: transform 0.5s ease; }
        .product-card:hover .product-img { transform: scale(1.05); }

        .best-seller-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, #F2AF17 0%, #e09e15 100%);
            color: #2c2c2c;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            z-index: 11;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-tambah { background-color: #F2AF17; color: black; border-radius: 50px; font-weight: 700; font-size: 0.85rem; border: none; padding: 8px 15px; transition: all 0.2s ease-in-out; }
        .btn-tambah:hover { background-color: #e09e15; transform: translateY(-2px); }
        .btn-tambah:active { transform: scale(0.95); }
        .icon-tambah { background-color: #212529; color: #F2AF17; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.6rem; margin-right: 6px; }

        .sidebar-wrapper {
            background-color: #ffffff;
            border-radius: 24px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.06);
            overflow: hidden;
        }
        
        .sidebar-dark { 
            background-color: #222222; 
            color: white; 
            border-bottom: 4px solid #F2AF17;
            padding: 1.5rem;
        }

        .logo-sidebar {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .cart-item { 
            border: 1px solid #e9ecef; 
            border-radius: 16px; 
            background-color: #ffffff; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
            transition: all 0.2s ease;
        }
        .cart-item:hover { border-color: #F2AF17; }
        
        .qty-btn { background-color: #212529; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border: none; font-size: 0.8rem; transition: all 0.2s; }
        .qty-btn:hover { background-color: #F2AF17; color: black; }
        .qty-btn:active { transform: scale(0.9); }

        .summary-container {
            background: #ffffff;
            z-index: 5;
            padding: 1.5rem;
            border-top: 1px solid #f1f3f5;
        }

        .detail-pesanan { 
            background-color: #fffcf5; 
            border: 2px dashed #f2ce7c;
            border-radius: 16px; 
            padding: 1rem;
            transition: all 0.3s ease; 
        }
        .detail-pesanan:hover { border-color: #F2AF17; }
        
        .btn-checkout { 
            background-color: #F2AF17; 
            color: black; 
            border-radius: 50px; 
            font-weight: 800; 
            padding: 14px; 
            border: none; 
            box-shadow: 0 6px 15px rgba(242, 175, 23, 0.25); 
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .btn-checkout:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(242, 175, 23, 0.4); background-color: #e5a30e; }
        .btn-checkout:active:not(:disabled) { transform: scale(0.98); }

        @keyframes pulse-soft {
            0% { box-shadow: 0 0 0 0 rgba(242, 175, 23, 0.5); }
            70% { box-shadow: 0 0 0 15px rgba(242, 175, 23, 0); }
            100% { box-shadow: 0 0 0 0 rgba(242, 175, 23, 0); }
        }
        .btn-checkout.ready { animation: pulse-soft 2.5s infinite; }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        .empty-cart-icon { animation: float 3s ease-in-out infinite; color: #dee2e6; }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #ced4da; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #adb5bd; }
        
        [x-cloak] { display: none !important; }

        .logo-header {
            height: 50px;
            width: auto;
        }

        /* ===== POPUP OVERLAY ===== */
        .popup-overlay {
            background: rgba(44, 44, 44, 0.6);
            backdrop-filter: blur(4px);
        }

        .popup-container {
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            position: relative;
        }

        .popup-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: #F2AF17;
            z-index: 1;
        }

        .popup-header {
            background: #ffffff;
            padding: 1.5rem;
            position: relative;
            border-bottom: 2px solid #F2AF17;
            text-align: center;
        }

        .popup-header h4 {
            color: #2c2c2c;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .popup-header h4 i {
            color: #F2AF17;
            margin-right: 8px;
        }

        /* ===== PRODUCT DETAIL POPUP ===== */
        .product-detail-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        .size-card {
            border: 2px solid #f0f0f0;
            border-radius: 20px;
            padding: 15px;
            cursor: pointer;
            flex: 1;
            text-align: center;
            transition: all 0.2s ease;
        }
        .size-card:hover {
            border-color: #F2AF17;
            background-color: #fffbf0;
        }
        .size-card.active {
            border-color: #F2AF17;
            background-color: #fffbf0;
            box-shadow: 0 0 0 3px rgba(242,175,23,0.15);
        }

        /* ===== PAYMENT POPUP ===== */
        .payment-option-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .payment-option-card:hover {
            border-color: #F2AF17;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            background: #ffffff;
        }

        .payment-option-card.selected {
            border-color: #F2AF17;
            background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
            box-shadow: 0 0 0 3px rgba(242,175,23,0.15);
        }

        .payment-option-card i {
            transition: all 0.3s ease;
        }

        .payment-option-card:hover i {
            transform: scale(1.1);
        }

        .input-modern {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .input-modern:focus {
            border-color: #F2AF17;
            background: white;
            box-shadow: 0 0 0 4px rgba(242,175,23,0.1);
            outline: none;
        }

        .btn-popup-primary {
            background: linear-gradient(135deg, #F2AF17 0%, #e09e15 100%);
            color: #2c2c2c;
            font-weight: 800;
            padding: 14px;
            border-radius: 16px;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
            display: block;
        }

        .btn-popup-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(242,175,23,0.3);
        }

        .btn-popup-secondary {
            background: #f8f9fa;
            color: #2c2c2c;
            font-weight: 600;
            padding: 12px;
            border-radius: 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            width: 100%;
            display: block;
        }

        .btn-popup-secondary:hover {
            background: #e9ecef;
            border-color: #2c2c2c;
            transform: translateY(-1px);
        }

        .qris-card {
            background: #f8f9fa;
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            border: 2px solid #e9ecef;
        }

        .qris-image {
            background: white;
            padding: 1rem;
            border-radius: 20px;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .validation-error {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            color: #991b1b;
            margin-top: 8px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .info-card .label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .info-card .value {
            color: #2c2c2c;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .info-card .value.text-warning {
            color: #F2AF17 !important;
        }

        .menu-section {
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #F2AF17;
            display: inline-block;
            color: #2c2c2c;
        }
        .section-title i {
            color: #F2AF17;
            margin-right: 10px;
        }
        .empty-best-seller {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 20px;
            color: #6c757d;
        }
    </style>
    
    @stack('scripts')
</head>

<body @yield('body-attributes')>
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('body-scripts')
</body>
</html>