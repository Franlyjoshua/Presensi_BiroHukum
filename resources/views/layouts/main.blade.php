<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', env('APP_NAME', 'Aplikasi Presensi'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue-dark: #1A2940; 
            --primary-blue-mid: #2C3E50;  
            --primary-blue-light: #3A7CA5; 
            
            --accent-teal: #4A9D9C;
            --accent-purple: #6A4C9C; 

            --text-light-primary: #F8FAFC; 
            --text-light-secondary: #CBD5E1; 
            --text-link-active: var(--accent-teal);

                --navbar-bg: rgba(26, 41, 64, 0.75); 
            --navbar-border: rgba(100, 116, 139, 0.2); 
            
            --card-bg-default: rgba(255, 255, 255, 0.95); 
            --card-border-default: rgba(203, 213, 225, 0.2);
            --card-shadow-default: 0 8px 25px rgba(0,0,0,0.1);

            --footer-bg: rgba(15, 23, 42, 0.9); 
            --footer-text-color: #A0AEC0; 
            --footer-border-top: rgba(100, 116, 139, 0.15);

            --global-font-family: 'Poppins', sans-serif;
            --heading-font-family: 'Merriweather', serif;
            --default-border-radius: 0.5rem; 
        }

        body {
            font-family: var(--global-font-family);
            background-color: var(--primary-blue-dark);
            background-image: 
                radial-gradient(ellipse at 10% 15%, var(--primary-blue-light) 0%, transparent 50%),
                radial-gradient(ellipse at 85% 20%, var(--accent-teal) 0%, transparent 45%),
                radial-gradient(ellipse at 50% 90%, var(--accent-purple) 0%, transparent 55%),
                linear-gradient(175deg, 
                    var(--primary-blue-dark) 0%, 
                    var(--primary-blue-mid) 50%, 
                    #0f172a 100% 
                );
            background-attachment: fixed;
            color: var(--text-light-secondary);
            position: relative;
            overflow-x: hidden;
            transition: background-color 0.5s ease;
        }
        
       
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0; 
        }

        .page-wrapper { 
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar.modern-navbar {
            background-color: var(--navbar-bg) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2) !important;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--navbar-border) !important;
            position: sticky; 
            top: 0;
            z-index: 1030; 
        }
        .navbar-brand.app-title {
            font-family: var(--heading-font-family);
            font-weight: 700 !important;
            font-size: 1.5rem; 
            color: var(--text-light-primary) !important;
        }
        .modern-navbar .nav-link {
            color: var(--text-light-secondary) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: var(--default-border-radius);
            transition: color 0.2s ease, background-color 0.2s ease;
            font-size: 0.925rem;
        }
        .modern-navbar .nav-link:hover {
            color: var(--text-light-primary) !important;
            background-color: rgba(255, 255, 255, 0.08);
        }
        .modern-navbar .nav-link.active {
            color: var(--text-link-active) !important;
            font-weight: 600;
            background-color: rgba(var(--accent-teal), 0.15);
        }
        .modern-navbar .navbar-toggler {
            border-color: rgba(255,255,255,0.2);
        }
        .modern-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28203, 213, 225, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .modern-navbar .dropdown-menu {
            background-color: var(--navbar-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--default-border-radius);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border: 1px solid var(--navbar-border);
            margin-top: 0.4rem !important;
        }
        .modern-navbar .dropdown-item {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            color: var(--text-light-secondary);
        }
        .modern-navbar .dropdown-item:hover,
        .modern-navbar .dropdown-item.active, 
        .modern-navbar .dropdown-item:active {
             background-color: var(--primary-blue-light) !important;
             color: var(--text-light-primary) !important;
        }
        .modern-navbar .dropdown-divider {
            border-top-color: var(--navbar-border);
        }

        main.container.main-content-area { 
            padding-top: 2.5rem; 
            padding-bottom: 3rem; 
            flex-grow: 1;
        }
        
        .card { 
            border: none; 
            border-radius: var(--default-border-radius);
            box-shadow: 0 5px 15px rgba(0,0,0,0.07);
            margin-bottom: 1.75rem; 
            background-color: var(--card-bg-default); 
            color: var(--text-dark); 
        }
        .card .card-header { 
            background-color: transparent; 
            border-bottom: 1px solid var(--card-border-default);
            padding: 1rem 1.25rem;
            font-weight: 600; 
            color: var(--primary-blue-dark); 
        }
         .card .card-header h5 { 
            margin-bottom: 0;
            font-size: 1.1rem; 
        }
        
        .card.glassmorphic-card { 
            background: var(--card-bg-glass) !important; 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--card-border-glass) !important; 
            box-shadow: 0 10px 35px 0 var(--card-shadow-glass);
            color: var(--text-light-primary); 
        }
        .card.glassmorphic-card .card-header {
            background-color: rgba(74, 157, 156, 0.15) !important; 
            border-bottom: 1px solid var(--card-border-glass) !important;
            color: var(--text-light-primary);
        }
         .card.glassmorphic-card .card-header h5 {
            color: var(--text-light-primary);
        }
        .card.glassmorphic-card ::placeholder { 
            color: rgba(203, 213, 225, 0.6); 
        }
        .card.glassmorphic-card .form-control { 
            background-color: rgba(15, 23, 42, 0.5); 
            border-color: rgba(100, 116, 139, 0.4); 
            color: var(--text-light-primary);
        }
        .card.glassmorphic-card .form-control:focus {
            background-color: rgba(30, 41, 59, 0.6);
            border-color: var(--accent-teal); 
            box-shadow: 0 0 0 0.2rem rgba(var(--accent-teal), 0.25);
            color: var(--text-light-primary);
        }
        .card.glassmorphic-card .table { color: var(--text-light-secondary); }
        .card.glassmorphic-card .table thead.table-light th { background-color: rgba(255,255,255,0.05) !important; color: var(--text-light-secondary); border-color: var(--card-border-glass); }
        .card.glassmorphic-card .table td, .card.glassmorphic-card .table th { border-color: var(--card-border-glass); }
        .card.glassmorphic-card .table tbody tr:hover { background-color: rgba(255,255,255,0.08) !important; }
        .card.glassmorphic-card .dataTables_length label,
        .card.glassmorphic-card .dataTables_filter label,
        .card.glassmorphic-card .dataTables_info { color: var(--text-light-secondary); }
        .card.glassmorphic-card .page-link { background-color: rgba(255,255,255,0.05); border-color: var(--card-border-glass); color: var(--text-light-secondary); }
        .card.glassmorphic-card .page-item.active .page-link { background-color: var(--accent-teal) !important; border-color: var(--accent-teal) !important; color: var(--primary-blue-dark) !important; }
        .card.glassmorphic-card .page-link:hover { background-color: rgba(255,255,255,0.1); color: var(--text-light-primary); }


        .site-footer-aurora { 
            background-color: var(--footer-bg); 
            color: var(--footer-text-color);
            padding-top: 1.75rem;
            padding-bottom: 1.75rem;
            margin-top: auto; 
            font-size: 0.875rem;
            border-top: 1px solid var(--footer-border-top);
            text-align: center;
        }
        .site-footer-aurora small {
            font-weight: 400;
        }
        .site-footer-aurora a {
            color: var(--accent-teal);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .site-footer-aurora a:hover {
            color: var(--text-light-primary);
            text-decoration: underline;
        }

    </style>
    @stack('css') 
</head>

<body class="d-flex flex-column min-vh-100">
    
    <div id="particles-js"></div>

    <div class="page-wrapper"> 
        <nav class="navbar modern-navbar navbar-expand-lg sticky-top"> 
            <div class="container">
                <a class="navbar-brand app-title" href="{{ route('home') }}">{{env('APP_NAME', 'Presensi App')}}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        @auth
                            @if(Auth::user()->is_admin)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.presence.index') || request()->is('admin/presence*') ? 'active' : '' }}" href="{{ route('admin.presence.index') }}">Manajemen Presensi</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                            @if (Route::has('admin.login.form'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.login.form') ? 'active' : '' }}" href="{{ route('admin.login.form') }}">Login Admin</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16" style="margin-bottom: 1px; vertical-align: middle;">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                    </svg>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAdmin">
                                    @if (Auth::user()->is_admin)
                                        <li><a class="dropdown-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                        
                                        {{-- ====== TAMBAHAN START: Menu Ganti Password ====== --}}
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('admin.password.change') ? 'active' : '' }}" href="{{ route('admin.password.change') }}">
                                                Ganti Password
                                            </a>
                                        </li>
                                        {{-- ====== TAMBAHAN END ====== --}}

                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container main-content-area py-4 flex-fill"> 
            @yield('content')
        </main>

        <footer class="site-footer-aurora mt-auto"> 
            <div class="container text-center">
                <small>&copy; {{ date('Y') }} {{ env('APP_NAME', 'Aplikasi Presensi') }}. All Rights Reserved.</small>
            </div>
        </footer>
    </div> 

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        
        if (document.getElementById('particles-js')) {
            particlesJS("particles-js", {
                "particles": {
                    "number": {"value": 50, "density": {"enable": true, "value_area": 800}}, 
                    "color": {"value": "#5C8DBC"}, 
                    "shape": {"type": "circle"},
                    "opacity": {"value": 0.1, "random": true, "anim": {"enable": true, "speed": 0.2, "opacity_min": 0.02, "sync": false}},
                    "size": {"value": 1.5, "random": true, "anim": {"enable": false}},
                    "line_linked": {"enable": false}, 
                    "move": {"enable": true, "speed": 0.4, "direction": "none", "random": true, "straight": false, "out_mode": "out", "bounce": false}
                },
                "interactivity": {"detect_on": "canvas", "events": {"onhover": {"enable": false}, "onclick": {"enable": false}, "resize": true}},
                "retina_detect": true
            });
        }
    </script>

    @stack('js')
</body>
</html>