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
            .site-header nav ul{list-style:none;display:flex;gap:1.5rem;margin:0;padding:0;align-items:center}
            .site-header nav a{position:relative;padding:.5rem .25rem;display:flex;align-items:center}
            .site-header nav a::after{content:'';position:absolute;left:0;bottom:-4px;width:0;height:2px;background:#fff;transition:width .2s}
            .site-header nav a:hover::after{width:100%}
            .logo{font-weight:800;letter-spacing:.5px;font-size:1.5rem;display:flex;align-items:center}
            .site-footer{text-align:center;padding:2rem;color:#666}
            .btn{display:inline-block;padding:.5rem 1rem;border-radius:8px;text-decoration:none;border:none;cursor:pointer;transition:.15s;background:#eaeaea;color:#222}
            .btn-sm{padding:.35rem .75rem;font-size:.9rem}.btn-primary{background:var(--primary);color:#fff}
            .btn-secondary{background:#ddd;color:#333}.btn-danger{background:#dc3545;color:#fff}
            .form-control{width:100%;padding:.6rem .8rem;border:2px solid #e5e7eb;border-radius:8px;background:#fff;outline:none;transition:all .2s ease-in-out}
            select.form-control{appearance:none;-webkit-appearance:none;-moz-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B0000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .75rem center;background-size:1.25rem;padding-right:2.5rem;cursor:pointer;border-radius:8px}
            .form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(139,0,0,.15)}
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
            .product-actions{margin-top:auto;display:flex;align-items:stretch;gap:.5rem}
            .product-actions .badge{flex-shrink:0;white-space:nowrap;padding:.5rem .75rem;display:inline-flex;align-items:center;justify-content:center;border-radius:8px}
            .product-actions .btn{flex:1;white-space:nowrap;display:inline-flex;align-items:center;justify-content:center;padding:.5rem .75rem}
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
            .search-select{padding:.8rem;border:2px solid var(--primary);border-radius:8px;background:#fff;appearance:none;-webkit-appearance:none;-moz-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B0000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .75rem center;background-size:1.25rem;padding-right:2.5rem;cursor:pointer;transition:all .2s ease-in-out}
            .search-select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(139,0,0,.15)}
            .search-button{padding:.8rem 1rem}
            .filter-bar{display:flex;gap:.35rem;flex-wrap:nowrap;margin-bottom:1.5rem;justify-content:center;align-items:center;width:100%}
            .filter-bar select, .filter-bar input, .filter-bar button{flex:0 1 auto;width:auto;min-width:0}
            .filter-bar .search-input{flex:1;min-width:150px;max-width:300px}
            .filter-bar .form-control{padding:.5rem .75rem}
            .filter-bar select.form-control{padding-right:2rem;background-position:right .5rem center}
            .pagination{display:flex;justify-content:center;gap:.5rem;list-style:none;padding:0;margin:2rem 0}
            .pagination li{display:inline-block}
            .pagination .page-link, .pagination span{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;padding:0 .5rem;border-radius:10px;background:#fff;color:#666;text-decoration:none;font-weight:600;transition:all .2s;border:1px solid #e8e4dc;box-shadow:0 2px 4px rgba(0,0,0,.03)}
            .pagination .active .page-link, .pagination .active span{background:var(--primary);color:#fff;border-color:var(--primary);box-shadow:0 4px 8px rgba(139,0,0,.2)}
            .pagination .page-link:hover:not(.active){background:#fdfcfa;border-color:var(--primary);color:var(--primary);transform:translateY(-2px)}
            .pagination .disabled span, .pagination .disabled .page-link{opacity:.5;cursor:default;background:#f5f2eb;color:#aaa}
            .dataTables_wrapper .dataTables_filter input{border:2px solid #e5e7eb;border-radius:8px;padding:.4rem .6rem;margin-left:.5rem}
            .dataTables_wrapper .dataTables_length select{appearance:none;-webkit-appearance:none;-moz-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B0000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .5rem center;background-size:1rem;padding-right:1.75rem;border:2px solid #e5e7eb;border-radius:8px;padding:.35rem .5rem;margin-right:.5rem;cursor:pointer}
            .dataTables_wrapper .dataTables_paginate .paginate_button{border-radius:6px;padding:.25rem .5rem;margin:0 .125rem;background:#eee;color:#333 !important}

            /* User Dropdown */
            .user-dropdown { position: relative; display: inline-block; }
            .user-dropbtn { 
                display: flex; 
                align-items: center; 
                gap: .5rem; 
                color: #fff; 
                text-decoration: none; 
                padding: .5rem .5rem; 
                border-radius: 10px; 
                transition: background .2s; 
                cursor: pointer;
                border: none;
                background: transparent;
                font-family: inherit;
                font-size: inherit;
                font-weight: 500;
                line-height: 1;
            }
            .user-dropbtn:hover { background: rgba(255,255,255,.1); }
            .user-icon { 
                width: 32px; 
                height: 32px; 
                border-radius: 50%; 
                object-fit: cover; 
                background: var(--light-beige); 
                border: 2px solid rgba(255,255,255,.2);
            }
            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                top: calc(100% + 10px);
                background-color: #fff;
                min-width: 200px;
                box-shadow: 0 10px 30px rgba(0,0,0,.15);
                border-radius: 14px;
                overflow: hidden;
                z-index: 100;
                border: 1px solid #f0ede6;
                padding: .5rem 0;
            }
            .dropdown-content a, .dropdown-content button {
                color: #444 !important;
                padding: .75rem 1.25rem;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: .85rem;
                font-size: .92rem;
                font-weight: 600;
                transition: all .2s;
                width: 100%;
                text-align: left;
                background: none;
                border: none;
                cursor: pointer;
                font-family: inherit;
            }
            .dropdown-content a:hover, .dropdown-content button:hover { 
                background-color: #fdfcfa; 
                color: var(--primary) !important; 
                padding-left: 1.5rem;
            }
            .dropdown-divider { height: 1px; background: #f0ede6; margin: .5rem 0; }
            .user-dropdown.active .dropdown-content { display: block; }
            .user-dropdown.active .user-dropbtn { background: rgba(255,255,255,.15); }
            .dropdown-content svg { color: #888; transition: color .2s; width: 18px; height: 18px; }
            .dropdown-content a:hover svg, .dropdown-content button:hover svg { color: var(--primary); }
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
                    @if(request()->is('admin*'))
                        <li><a href="{{ route('home') }}">View Site</a></li>
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="user-dropdown" id="adminUserDropdown">
                            <button class="user-dropbtn" onclick="toggleUserDropdown(event)">
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="" class="user-icon">
                                {{ auth()->user()->username ?? auth()->user()->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="dropdown-content">
                                <a href="{{ route('profile.edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Edit Profile
                                </a>
                                <a href="{{ route('orders.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    My Orders
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        @auth
                            <li><a href="{{ route('cart.index') }}">Cart @if(isset($cartCount) && $cartCount > 0)<span class="cart-count">{{ $cartCount }}</span>@endif</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            @endif
                            <li class="user-dropdown" id="userDropdown">
                                <button class="user-dropbtn" onclick="toggleUserDropdown(event)">
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="" class="user-icon">
                                    {{ auth()->user()->username ?? auth()->user()->name }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="dropdown-content">
                                    <a href="{{ route('profile.edit') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Edit Profile
                                    </a>
                                    <a href="{{ route('orders.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        My Orders
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endauth
                    @endif
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

    <script>
        function toggleUserDropdown(event) {
            event.stopPropagation();
            const dropdown = event.currentTarget.closest('.user-dropdown');
            dropdown.classList.toggle('active');
            
            // Close other dropdowns if any
            document.querySelectorAll('.user-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.remove('active');
            });
        }

        window.onclick = function(event) {
            if (!event.target.closest('.user-dropdown')) {
                document.querySelectorAll('.user-dropdown').forEach(d => {
                    d.classList.remove('active');
                });
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
