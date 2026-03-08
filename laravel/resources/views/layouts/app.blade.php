<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Pop Stop')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css','resources/js/app.js'])
    @else
        <style>
            :root{--primary:#8B0000;--accent:#B22222;--dark-brown:#1F1B1B;--light-beige:#EFEBD8;--secondary:#3B3B3B;--bg:#F3F1EA}
            *{box-sizing:border-box}html,body{height:100%}body{font-family:system-ui,sans-serif;margin:0;background:var(--bg);color:#222}
            .page-container{max-width:1200px;margin:0 auto;padding:1rem 2rem}
            .site-header{background:var(--primary);color:#fff;padding:1rem 2rem;position:sticky;top:0;z-index:50;background:linear-gradient(90deg,var(--accent),var(--primary));box-shadow:0 2px 8px rgba(0,0,0,.15)}
            .header-container{max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center}
            .site-header a{color:#fff;text-decoration:none}
            .site-header nav ul{list-style:none;display:flex;gap:1.5rem;margin:0;padding:0}
            .site-header nav a{position:relative;padding:.25rem .25rem}
            .site-header nav a::after{content:'';position:absolute;left:0;bottom:-4px;width:0;height:2px;background:#fff;transition:width .2s}
            .site-header nav a:hover::after{width:100%}
            .logo{font-weight:800;letter-spacing:.5px;font-size:1.25rem}
            .site-footer{text-align:center;padding:2rem;color:#666}
            .btn{display:inline-block;padding:.5rem 1rem;border-radius:8px;text-decoration:none;border:none;cursor:pointer;transition:.15s;background:#eaeaea;color:#222}
            .btn-sm{padding:.35rem .75rem;font-size:.9rem}.btn-primary{background:var(--primary);color:#fff}
            .btn-secondary{background:#ddd;color:#333}.btn-danger{background:#dc3545;color:#fff}
            .alert{padding:1rem;border-radius:8px;margin-bottom:1rem}.alert-success{background:#d4edda;color:#155724}
            .alert-error,.alert-danger{background:#f8d7da;color:#721c24}
            .product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.25rem}
            .product-card{border:1px solid #eee;border-radius:12px;overflow:hidden;background:#fff;transition:transform .15s ease,box-shadow .15s ease;box-shadow:0 1px 2px rgba(0,0,0,.04);display:flex;flex-direction:column;min-height:420px}
            .product-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.12)}
            .product-card .media{height:220px;background:var(--light-beige);display:flex;align-items:center;justify-content:center;overflow:hidden;flex:0 0 220px}
            .product-card img{width:100%;height:100%;object-fit:cover;transition:transform .25s ease}
            .product-card:hover img{transform:scale(1.05)}
            .product-info{padding:1rem;display:flex;flex-direction:column;gap:.35rem;flex:1}
            .cart-count{background:#fff;color:var(--primary);padding:.2rem .5rem;border-radius:50%;font-size:.85rem}
            .product-actions{margin-top:auto}
            .btn-block{width:100%}
            .cart-count{background:#fff;color:var(--primary);padding:.2rem .5rem;border-radius:50%;font-size:.85rem}
            .badge{display:inline-block;padding:.2rem .5rem;border-radius:999px;font-size:.75rem;font-weight:700}
            .badge-success{background:#d1fae5;color:#065f46}
            .product-actions{margin-top:auto}
            .btn-block{width:100%}
            .badge-warning{background:#fef3c7;color:#92400e}
            .badge-danger{background:#fee2e2;color:#7f1d1d}
            .badge-secondary{background:#e5e7eb;color:#111827}
            .hero{text-align:center;padding:2rem 0}
            .hero h1{font-size:2rem;margin-bottom:.25rem}
            .search-form{max-width:900px;margin:2rem auto}
            .search-form .input-group{display:flex;gap:.5rem}
            .search-input{flex:1;padding:.8rem 1rem;border:2px solid var(--primary);border-radius:9999px;background:#fff;outline:none}
            .search-input:focus{box-shadow:0 0 0 3px rgba(139,0,0,.15)}
            .search-select{padding:.8rem;border:2px solid var(--primary);border-radius:12px;background:#fff}
            .search-button{padding:.8rem 1rem}
            .filter-bar{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1rem;justify-content:center}
            .pagination{display:flex;justify-content:center;gap:.35rem;list-style:none;padding:0;margin-top:1.25rem}
            .pagination li{list-style:none}
            .pagination .page-link{display:inline-block;padding:.4rem .7rem;border-radius:8px;background:#eee;color:#333;text-decoration:none}
            .pagination .active .page-link{background:var(--primary);color:#fff}
            .pagination .disabled .page-link{opacity:.5;cursor:default}
        </style>
    @endif
    @stack('styles')
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo text-white">The Pop Stop</a>
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart @if(isset($cartCount) && $cartCount > 0)<span class="cart-count">{{ $cartCount }}</span>@endif</a></li>
                        @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                        @endif
                        <li>
                            <a href="{{ route('profile.edit') }}">{{ auth()->user()->username ?? auth()->user()->name }}</a>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-secondary btn-sm">Logout</button></form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main class="container page-container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer">
        &copy; {{ date('Y') }} The Pop Stop. All rights reserved.
    </footer>
    @stack('scripts')
</body>
</html>
