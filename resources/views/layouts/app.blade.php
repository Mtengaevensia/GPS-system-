<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom CSS -->
        <style>
            :root {
                --bs-primary-rgb: 79, 70, 229;
                --bs-success-rgb: 16, 185, 129;
                --bs-dark-rgb: 31, 41, 55;
            }
            
            body {
                min-height: 100vh;
            }
            
            /* Sidebar styles */
            #sidebar {
                width: 250px;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 999;
                background: #fff;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: all 0.3s;
            }
            
            #sidebar.collapsed {
                margin-left: -250px;
            }
            
            /* Main content styles */
            #content {
                width: calc(100% - 250px);
                min-height: 100vh;
                transition: all 0.3s;
                position: absolute;
                top: 0;
                right: 0;
            }
            
            #content.expanded {
                width: 100%;
            }
            
            /* Dark mode adjustments */
            .dark-mode #sidebar {
                background: #1F2937;
                color: #f9fafb;
            }
            
            .dark-mode .card {
                background-color: #1F2937;
                color: #f9fafb;
            }
            
            .dark-mode .bg-light {
                background-color: #374151 !important;
            }
            
            .dark-mode .text-muted {
                color: #9ca3af !important;
            }
            
            .dark-mode .table-light {
                background-color: #374151;
                color: #f9fafb;
            }
            
            /* Responsive adjustments */
            @media (max-width: 991.98px) {
                #sidebar {
                    margin-left: -250px;
                }
                
                #sidebar.active {
                    margin-left: 0;
                }
                
                #content {
                    width: 100%;
                }
                
                #content.active {
                    width: calc(100% - 250px);
                }
                
                #sidebarCollapse span {
                    display: none;
                }
            }
        </style>

        @livewireStyles
    </head>
    <body class="bg-light" data-bs-theme="light">
        <x-banner />

        <div class="wrapper d-flex align-items-stretch">
            <!-- Sidebar -->
            <nav id="sidebar" class="collapsed d-lg-block">
                <div class="p-4">
                    <!-- Logo -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                            <x-application-mark class="block h-9 w-auto" />
                            <span class="ms-3 fs-4 fw-semibold text-dark">GPS Navigator</span>
                        </a>
                        <button id="sidebarCollapseClose" class="btn btn-sm d-lg-none">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    
                    <!-- Navigation Links -->
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ url('dashboard') }}" class="nav-link px-3 py-2 rounded {{ request()->is('dashboard') ? 'text-white bg-primary' : 'text-dark' }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('vehicle/index') }}" class="nav-link px-3 py-2 rounded {{ request()->is('vehicle/*') ? 'text-white bg-primary' : 'text-dark' }}">
                                <i class="bi bi-truck me-2"></i>
                                {{ __('Vehicles') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('driver/index') }}" class="nav-link px-3 py-2 rounded {{ request()->is('driver/*') ? 'text-white bg-primary' : 'text-dark' }}">
                                <i class="bi bi-person me-2"></i>
                                {{ __('Drivers') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('trips/index') }}" class="nav-link px-3 py-2 rounded {{ request()->is('trips/*') ? 'text-white bg-primary' : 'text-dark' }}">
                                <i class="bi bi-map me-2"></i>
                                {{ __('Trips') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('alerts/index') }}" class="nav-link px-3 py-2 rounded {{ request()->is('alerts/*') ? 'text-white bg-primary' : 'text-dark' }}">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ __('Alerts') }}
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('settings/index') }}" class="nav-link px-3 py-2 rounded {{ request()->is('settings/*') ? 'text-white bg-primary' : 'text-dark' }}">
                                <i class="bi bi-gear me-2"></i>
                                {{ __('Settings') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Page Content -->
            <div id="content" class="expanded d-lg-block">
                <!-- Top Navigation Bar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <!-- Mobile menu button -->
                        <button id="sidebarCollapse" class="btn d-lg-none me-2">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        
                        <!-- Page Title (Mobile Only) -->
                        <span class="navbar-brand d-lg-none">
                            {{ $header ?? 'Dashboard' }}
                        </span>
                        
                        <div class="ms-auto d-flex align-items-center">
                            <!-- Theme Toggle -->
                            <button id="themeToggle" class="btn btn-sm me-2">
                                <i class="bi bi-moon-stars"></i>
                            </button>
                            
                            <!-- User Dropdown -->
                            <div class="dropdown">
                                <button class="btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <img class="rounded-circle me-2" width="32" height="32" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    @else
                                        <span class="me-2">{{ Auth::user()->name }}</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header">{{ __('Manage Account') }}</h6></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <li><a class="dropdown-item" href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow-sm">
                        <div class="container-fluid py-3">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="container-fluid py-4">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Custom JS -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sidebar toggle
                const sidebar = document.getElementById('sidebar');
                const content = document.getElementById('content');
                const sidebarCollapse = document.getElementById('sidebarCollapse');
                const sidebarCollapseClose = document.getElementById('sidebarCollapseClose');
                
                if (sidebarCollapse) {
                    sidebarCollapse.addEventListener('click', function() {
                        sidebar.classList.toggle('collapsed');
                        sidebar.classList.add('active');
                        content.classList.toggle('expanded');
                        content.classList.add('active');
                    });
                }
                
                if (sidebarCollapseClose) {
                    sidebarCollapseClose.addEventListener('click', function() {
                        sidebar.classList.add('collapsed');
                        sidebar.classList.remove('active');
                        content.classList.add('expanded');
                        content.classList.remove('active');
                    });
                }
                
                // Theme toggle
                const themeToggle = document.getElementById('themeToggle');
                const body = document.body;
                
                if (themeToggle) {
                    themeToggle.addEventListener('click', function() {
                        if (body.getAttribute('data-bs-theme') === 'dark') {
                            body.setAttribute('data-bs-theme', 'light');
                            body.classList.remove('dark-mode');
                            themeToggle.innerHTML = '<i class="bi bi-moon-stars"></i>';
                        } else {
                            body.setAttribute('data-bs-theme', 'dark');
                            body.classList.add('dark-mode');
                            themeToggle.innerHTML = '<i class="bi bi-sun"></i>';
                        }
                    });
                }
                
                // Handle responsive behavior
                function handleResize() {
                    if (window.innerWidth >= 992) {
                        sidebar.classList.remove('collapsed');
                        content.classList.remove('expanded');
                    } else {
                        sidebar.classList.add('collapsed');
                        content.classList.add('expanded');
                    }
                }
                
                // Initial call and event listener
                handleResize();
                window.addEventListener('resize', handleResize);
            });
        </script>

        @stack('modals')
        @livewireScripts
    </body>
</html>









