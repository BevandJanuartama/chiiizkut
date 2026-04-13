<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ChiiiZkut.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-chiiiz { background-color: #F2AF17; }
        .text-chiiiz { color: #F2AF17; }
        .border-chiiiz { border-color: #F2AF17; }
        .card-neo { background: white; border: 3px solid black; border-radius: 1.5rem; box-shadow: 8px 8px 0px 0px rgba(0,0,0,1); transition: all 0.2s ease; }
        .card-neo-orange { box-shadow: 8px 8px 0px 0px rgba(242,175,23,1); }
        .card-neo:hover { transform: translate(-2px, -2px); box-shadow: 10px 10px 0px 0px rgba(0,0,0,1); }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        @include('layouts.sidebar')

        <main class="flex-1 p-8 md:p-12">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>