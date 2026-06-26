<header class="site-header">
    <div class="container">
        <div class="header-wrapper">
            {{-- Mobile Menu Toggle (Left) --}}
            <button class="menu-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            {{-- Left Navigation (Desktop) --}}
            <nav class="nav-left d-none d-lg-block">
                <ul class="nav-list">
                    <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
                    <li><a href="{{ route('services.index') }}" class="nav-link">Services</a></li>
                </ul>
            </nav>

            {{-- Center Logo --}}
            <div class="logo-container">
                <a href="{{ route('home') }}" class="logo-link">
                    <div class="logo-rounded">
                        <img src="{{ asset('storage/logo/logo.png') }}" alt="Lumos Logo" class="logo-img">
                    </div>
                </a>
            </div>

            {{-- Right Navigation (Desktop) --}}
            <nav class="nav-right d-none d-lg-block">
                <ul class="nav-list">
                    <li><a href="{{ route('gallery') }}" class="nav-link">Gallery</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                    <li class="nav-cta"><a href="tel:0717199302" class="btn btn-primary btn-sm rounded-pill px-4">Call Now</a></li>
                </ul>
            </nav>

            {{-- Mobile CTA (Right) --}}
            <div class="mobile-cta d-lg-none">
                <a href="tel:0717199302" class="btn btn-primary btn-sm rounded-circle p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                </a>
            </div>
        </div>
    </div>
</header>

{{-- Offcanvas Mobile Menu --}}
<div class="offcanvas offcanvas-start mobile-menu-offcanvas" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileMenuLabel">
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Lumos Logo" height="40">
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="mobile-nav">
            <ul class="mobile-nav-list">
                <li><a href="{{ route('home') }}" class="mobile-nav-link">Home</a></li>
                <li><a href="{{ route('about') }}" class="mobile-nav-link">About</a></li>
                <li><a href="{{ route('services.index') }}" class="mobile-nav-link">Services</a></li>
                <li><a href="{{ route('gallery') }}" class="mobile-nav-link">Gallery</a></li>
                <li><a href="{{ route('contact') }}" class="mobile-nav-link">Contact</a></li>
            </ul>
        </nav>
        <div class="mobile-menu-footer mt-5 pt-4 border-top">
            <p class="text-muted small mb-2">Get in touch:</p>
            <a href="tel:0717199302" class="d-block mb-3 fw-bold text-decoration-none color-primary">071 719 9302</a>
            <div class="social-links d-flex gap-3">
                {{-- Add social icons here if needed --}}
            </div>
        </div>
    </div>
</div>
