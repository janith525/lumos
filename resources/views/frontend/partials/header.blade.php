@php
    $headerLinks = [];
    if (!empty($settings['header_links'])) {
        $headerLinks = json_decode($settings['header_links'], true) ?: [];
    }
    if (empty($headerLinks)) {
        $headerLinks = [
            ['label' => 'Home', 'url' => '{{SITE_URL}}/home'],
            ['label' => 'About', 'url' => '{{SITE_URL}}/about'],
            ['label' => 'Services', 'url' => '{{SITE_URL}}/services'],
            ['label' => 'Gallery', 'url' => '{{SITE_URL}}/gallery'],
            ['label' => 'Contact', 'url' => '{{SITE_URL}}/contact']
        ];
    }
    $totalLinks = count($headerLinks);
    $leftCount = ceil($totalLinks / 2);
    $leftLinks = array_slice($headerLinks, 0, $leftCount);
    $rightLinks = array_slice($headerLinks, $leftCount);
    
    $hotlineRaw = $settings['contact_phone'] ?? '071 719 9302';
    $hotlineClean = preg_replace('/[^0-9+]/', '', $hotlineRaw);
@endphp

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
                    @foreach($leftLinks as $item)
                        @php
                            $url = str_replace('{{SITE_URL}}', url('/'), $item['url']);
                        @endphp
                        <li><a href="{{ $url }}" class="nav-link">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            {{-- Center Logo --}}
            <div class="logo-container">
                <a href="{{ route('home') }}" class="logo-link">
                    <div class="logo-rounded">
                        <img src="{{ !empty($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('storage/logo/logo.png') }}" alt="Lumos Logo" class="logo-img">
                    </div>
                </a>
            </div>

            {{-- Right Navigation (Desktop) --}}
            <nav class="nav-right d-none d-lg-block">
                <ul class="nav-list">
                    @foreach($rightLinks as $item)
                        @php
                            $url = str_replace('{{SITE_URL}}', url('/'), $item['url']);
                        @endphp
                        <li><a href="{{ $url }}" class="nav-link">{{ $item['label'] }}</a></li>
                    @endforeach
                    <li class="nav-cta"><a href="tel:{{ $hotlineClean }}" class="btn btn-primary btn-sm rounded-pill px-4">Call Now</a></li>
                </ul>
            </nav>

            {{-- Mobile CTA (Right) --}}
            <div class="mobile-cta d-lg-none">
                <a href="tel:{{ $hotlineClean }}" class="btn btn-primary btn-sm rounded-circle p-2">
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
            <img src="{{ !empty($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('storage/logo/logo.png') }}" alt="Lumos Logo" height="40">
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="mobile-nav">
            <ul class="mobile-nav-list">
                @foreach($headerLinks as $item)
                    @php
                        $url = str_replace('{{SITE_URL}}', url('/'), $item['url']);
                    @endphp
                    <li><a href="{{ $url }}" class="mobile-nav-link">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </nav>
        <div class="mobile-menu-footer mt-5 pt-4 border-top">
            <p class="text-muted small mb-2">Get in touch:</p>
            <a href="tel:{{ $hotlineClean }}" class="d-block mb-3 fw-bold text-decoration-none color-primary">{{ $hotlineRaw }}</a>
            <div class="social-links d-flex gap-3">
                @if(!empty($settings['header_facebook']) && $settings['header_facebook'] !== '#')
                    <a href="{{ $settings['header_facebook'] }}" target="_blank" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                @endif
                @if(!empty($settings['header_instagram']) && $settings['header_instagram'] !== '#')
                    <a href="{{ $settings['header_instagram'] }}" target="_blank" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                @endif
                @if(!empty($settings['header_linkedin']) && $settings['header_linkedin'] !== '#')
                    <a href="{{ $settings['header_linkedin'] }}" target="_blank" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
                @endif
            </div>
        </div>
    </div>
</div>
