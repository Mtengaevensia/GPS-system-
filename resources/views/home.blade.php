<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="GPS Navigator - Real-time vehicle tracking and fleet management system">
    
    <title>GPS Navigator | Home</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- Custom styles -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        .feature-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bg-primary-light {
            background-color: rgba(13, 110, 253, 0.1);
        }
        .bg-success-light {
            background-color: rgba(25, 135, 84, 0.1);
        }
        .bg-info-light {
            background-color: rgba(13, 202, 240, 0.1);
        }
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }
        @media (max-width: 767.98px) {
            .login-card {
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" aria-label="GPS Navigator Home">
                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                GPS Navigator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('alerts/index') }}">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Alerts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <!-- Left Column: Welcome Content -->
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3">Welcome to GPS Navigator</h1>
                    <p class="lead text-secondary mb-4">
                        Track your vehicles in real-time with precision and ease. Our system helps you stay connected to your fleet anytime, anywhere.
                    </p>
                    
                    <!-- Feature List -->
                    <div class="row g-4 py-2">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon bg-primary-light me-3">
                                    <i class="bi bi-geo-alt text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Real-time tracking</h5>
                                    <p class="text-muted small mb-0">Monitor vehicles with live updates</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon bg-success-light me-3">
                                    <i class="bi bi-bell text-success fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Instant alerts</h5>
                                    <p class="text-muted small mb-0">Get SMS & Email notifications</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon bg-info-light me-3">
                                    <i class="bi bi-map text-info fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Route optimization</h5>
                                    <p class="text-muted small mb-0">Save fuel with smart planning</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon bg-warning-light me-3">
                                    <i class="bi bi-download text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Offline maps</h5>
                                    <p class="text-muted small mb-0">Access maps without internet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Login Form -->
                <div class="col-lg-5 offset-lg-1">
                    <div class="card shadow-sm login-card">
                        <div class="card-body p-4">
                            <h2 class="card-title h4 fw-bold mb-4">Log In to Your Account</h2>
                            
                            @if (session('status'))
                                <div class="alert alert-success mb-3" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus aria-describedby="emailHelp">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">Remember me</label>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2">Sign In</button>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                            Forgot your password?
                                        </a>
                                    @endif
                                    
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="text-decoration-none small">
                                            Create an account
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-auto border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 small">
                    <span class="text-muted">&copy; {{ date('Y') }} GPS Navigator. All rights reserved.</span>
                </div>
                <div class="col-md-6 text-md-end small">
                    <a href="#" class="text-decoration-none text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-decoration-none text-muted me-3">Terms of Service</a>
                    <a href="#" class="text-decoration-none text-muted">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>




