<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Lumos CMS Admin' }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <style>
        :root {
            --color-blue: #3b82f6;
            --color-blue-dark: #1d4ed8;
            --color-blue-glow: rgba(59, 130, 246, 0.25);
            --color-black: #090d16;
            --transition-fast: 0.2s ease;
        }
        body {
            background-color: var(--color-black);
            font-family: 'Instrument Sans', sans-serif;
            color: #f1f5f9;
            overflow-x: hidden;
            min-height: 100vh;
        }
        .admin-section {
            padding: 40px 0;
            min-height: 100vh;
        }
        .admin-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
            align-items: start;
        }
        @media (max-width: 992px) {
            .admin-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
        
        /* Sidebar Navigation styling */
        .admin-sidebar {
            background: rgba(13, 20, 35, 0.7);
            border: 1px solid rgba(59, 130, 246, 0.15);
            border-radius: 24px;
            padding: 32px 24px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5), 0 0 24px rgba(59, 130, 246, 0.03);
        }
        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        .admin-logo {
            filter: brightness(0) invert(1);
            height: 38px;
        }
        .admin-brand-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .admin-user-card {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            padding: 16px;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 16px;
        }
        .admin-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--color-blue);
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.4);
        }
        .admin-user-info h3 {
            color: #ffffff;
            font-size: 14px;
            margin: 0 0 2px;
            font-weight: 700;
        }
        .admin-user-info span {
            font-size: 11px;
            color: var(--color-blue);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .admin-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .admin-menu-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 20px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: all var(--transition-fast);
            border: 1px solid transparent;
        }
        .admin-menu-item svg {
            transition: transform 0.3s;
            flex-shrink: 0;
        }
        .admin-menu-item:hover {
            color: var(--color-blue);
            background: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.1);
            padding-left: 24px;
        }
        .admin-menu-item.active {
            background: linear-gradient(135deg, var(--color-blue) 0%, var(--color-blue-dark) 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 15px var(--color-blue-glow);
        }
        
        /* Main Panel styling */
        .admin-content-card {
            background: rgba(13, 20, 35, 0.5);
            border: 1px solid rgba(59, 130, 246, 0.15);
            border-radius: 28px;
            padding: 48px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }
        @media (max-width: 768px) {
            .admin-content-card {
                padding: 30px 20px;
            }
        }
        
        .admin-header {
            margin-bottom: 32px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .admin-title {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .admin-subtitle {
            font-size: 14px;
            color: #94a3b8;
            margin-top: 4px;
        }
        
        /* Form Overrides */
        .form-group-admin {
            margin-bottom: 24px;
        }
        .form-group-admin label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-group-admin .form-control {
            background: rgba(255, 255, 255, 0.02);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-group-admin .form-control:focus {
            border-color: var(--color-blue);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            outline: none;
        }
        
        .btn-blue {
            background: linear-gradient(135deg, var(--color-blue) 0%, var(--color-blue-dark) 100%) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            transition: all 0.3s !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            box-shadow: 0 4px 15px var(--color-blue-glow) !important;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        .btn-blue:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4) !important;
        }
        .text-blue {
            color: var(--color-blue) !important;
        }
    </style>
    @yield('admin_css')
</head>
<body>
    <section class="admin-section">
        <div class="container">
            <div class="admin-grid">
                <!-- Sidebar -->
                <div class="admin-sidebar">
                    <div class="admin-brand">
                        <span class="admin-brand-title">Lumos CMS</span>
                    </div>
                    
                    <div class="admin-user-card">
                        <div class="admin-avatar">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="admin-user-info">
                            <h3>{{ Auth::user()->name }}</h3>
                            <span>{{ Auth::user()->getRoleNames()->first() ?? 'Staff Member' }}</span>
                        </div>
                    </div>
                    
                    <div class="admin-menu">
                        <a href="{{ route('admin.dashboard') }}" class="admin-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- CMS Main Menu Section -->
                        <div class="text-blue mb-2 mt-3 px-3 fw-bold uppercase" style="font-size: 11px; letter-spacing: 1px; opacity: 0.8; color: var(--color-blue)">CMS MENU</div>
                        
                        @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Staff']))
                        <a href="{{ route('admin.products') }}" class="admin-menu-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            <span>Products</span>
                        </a>
                        <a href="{{ route('admin.services') }}" class="admin-menu-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                            <span>Services</span>
                        </a>
                        <a href="{{ route('admin.gallery') }}" class="admin-menu-item {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            <span>Gallery Showcase</span>
                        </a>
                        <a href="{{ route('admin.quotes') }}" class="admin-menu-item {{ request()->routeIs('admin.quotes*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <span>Quotes/Inquiries</span>
                        </a>
                        <a href="{{ route('admin.settings.home') }}" class="admin-menu-item {{ request()->routeIs('admin.settings.home') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span>Home Page CMS</span>
                        </a>
                        <a href="{{ route('admin.settings.about') }}" class="admin-menu-item {{ request()->routeIs('admin.settings.about') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            <span>About Page CMS</span>
                        </a>
                        <a href="{{ route('admin.settings.contact') }}" class="admin-menu-item {{ request()->routeIs('admin.settings.contact') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span>Contact Page CMS</span>
                        </a>
                        <a href="{{ route('admin.settings.navigation') }}" class="admin-menu-item {{ request()->routeIs('admin.settings.navigation') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>
                            <span>Header & Footer CMS</span>
                        </a>
                        <a href="{{ route('admin.settings') }}" class="admin-menu-item {{ request()->routeIs('admin.settings') && !request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            <span>General Settings</span>
                        </a>
                        @endif

                        <!-- Management Section -->
                        <div class="text-blue mb-2 mt-3 px-3 fw-bold uppercase" style="font-size: 11px; letter-spacing: 1px; opacity: 0.8; color: var(--color-blue)">MANAGEMENT</div>

                        <a href="{{ route('admin.staff') }}" class="admin-menu-item {{ request()->routeIs('admin.staff*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-3-3.87"></path><path d="M9 21v-2a4 4 0 0 0-4-4H3a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <span>Staff Management</span>
                        </a>
                        @if(Auth::user()->hasRole('Super Admin'))
                        <a href="{{ route('admin.roles') }}" class="admin-menu-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Roles & Permissions</span>
                        </a>
                        @endif
                        <a href="/" class="admin-menu-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span>View Website</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="admin-menu-item w-100 bg-transparent text-start" style="border: none; padding-left: 20px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Main Pane -->
                <div class="admin-content-card">
                    @yield('admin_content')
                </div>
            </div>
        </div>
    </section>
    
    @yield('admin_modals')
    
    <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('vendor/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    @yield('admin_scripts')
    @fluxScripts
</body>
</html>
