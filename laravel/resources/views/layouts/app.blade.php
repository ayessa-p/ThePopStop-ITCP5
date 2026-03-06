<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Pop Stop')</title>
    <style>
        :root { --primary: #8B4513; --dark-brown: #5D3A1A; --light-beige: #F5F5DC; --secondary: #666; }
        body { font-family: system-ui, sans-serif; margin: 0; background: #fafafa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 1rem 2rem; }
        header { background: var(--primary); color: white; padding: 1rem 2rem; }
        .header-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; }
        header nav ul { list-style: none; display: flex; gap: 1.5rem; margin: 0; padding: 0; }
        .btn { display: inline-block; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: #ddd; color: #333; }
        .btn-danger { background: #dc3545; color: white; }
        .alert { padding: 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error, .alert-danger { background: #f8d7da; color: #721c24; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }
        .product-card { border: 1px solid #eee; border-radius: 8px; overflow: hidden; background: white; }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-info { padding: 1rem; }
        .cart-count { background: #fff; color: var(--primary); padding: 0.2rem 0.5rem; border-radius: 50%; font-size: 0.85rem; }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">The Pop Stop</a>
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

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer style="text-align:center; padding: 2rem; color: #666;">
        &copy; {{ date('Y') }} The Pop Stop. All rights reserved.
    </footer>
    @stack('scripts')
</body>
</html>
