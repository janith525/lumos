@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/home.scss')
@section('classes_body', 'home-page')

@section('content')
    <section class="hero-slider-section">
        <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse($homeSlides as $index => $slide)
                    <a href="{{ $slide->button_link ?? '#services' }}" class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <picture>
                            <img src="{{ str_starts_with($slide->image, 'http') ? $slide->image : asset('storage/' . $slide->image) }}" class="d-block w-100 hero-img"
                                 alt="{{ $slide->title }}">
                        </picture>
                    </a>
                @empty
                    {{-- Fallback Slide 1 --}}
                    <a href="#services" class="carousel-item active">
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ asset('storage/hero/hero-1-mobile.jpeg') }}">
                            <img src="{{ asset('storage/hero/hero-1-desktop.jpeg') }}" class="d-block w-100 hero-img"
                                alt="Lumos Nursery Design">
                        </picture>
                    </a>

                    {{-- Fallback Slide 2 --}}
                    <a href="#furniture" class="carousel-item">
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ asset('storage/hero/hero-2-mobile.jpeg') }}">
                            <img src="{{ asset('storage/hero/hero-2-desktop.jpeg') }}" class="d-block w-100 hero-img"
                                alt="Lumos Bespoke Furniture">
                        </picture>
                    </a>
                @endforelse
            </div>

            {{-- Controls --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon p-3 rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon p-3 rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    {{-- About Section --}}
    <section class="about-section py-5 my-5" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image-wrapper pe-lg-5">
                        <img src="{{ isset($settings['home_about_image']) ? asset('storage/' . $settings['home_about_image']) : asset('storage/logo/logo.png') }}" alt="Lumos Studio" class="img-fluid rounded-4 shadow-sm opacity-50">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">{{ $settings['home_about_eyebrow'] ?? 'About Lumos' }}</span>
                        <h1 class="display-5 fw-bold mb-4">{!! preg_replace('/##(.*?)##/', '<span class="text-primary">$1</span>', $settings['home_about_title'] ?? 'Lumos: Sri Lanka\'s Pioneer Luxury Nursery Design & Kids Interior Studio') !!}</h1>
                        <p class="lead text-muted mb-4">
                            {{ $settings['about_story_lead'] ?? 'Lumos is a dedicated interior design studio based in Sri Lanka, specializing exclusively in nursery and baby room aesthetics. We are the first of our kind in the country, committed to creating "tiny dreams" for your little ones.' }}
                        </p>
                        <p class="mb-5 text-secondary">
                            {{ $settings['about_story_body1'] ?? 'From custom-made round cribs and wardrobes to specialized nursery lighting and backlit wall decor, we provide comprehensive setups that blend safety, comfort, and unmatched style. Our projects are highly personalized, integrating custom name signs and specialized textiles to make every room unique.' }}
                        </p>
                        <div class="about-actions d-flex gap-3 flex-wrap">
                            <a href="{{ route('about') }}" class="btn btn-primary btn-lg rounded-pill px-4 py-3">Discover Our Story</a>
                            <a href="#contact" class="btn btn-outline-primary btn-lg rounded-pill px-4 py-3">Inquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services & Products Section --}}
    <section class="services-section py-5 bg-light" id="services">
        <div class="container py-lg-4">
            <div class="section-header text-center mb-5">
                <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">{{ $settings['home_services_eyebrow'] ?? 'Our Expertise' }}</span>
                <h2 class="display-5 fw-bold text-dark">{!! preg_replace('/##(.*?)##/', '<span class="text-primary">$1</span>', $settings['home_services_title'] ?? 'Services & ##Specialized## Products') !!}</h2>
                <p class="text-muted mx-auto max-w-600">
                    We offer a comprehensive range of interior solutions designed to turn your nursery into a magical space for your baby.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                @php
                    $renderedCount = 0;
                @endphp
                @foreach($services as $service)
                    @if($renderedCount < 3)
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="catalog-item-card card border-0 w-100 d-flex flex-column justify-content-between">
                                <div class="card-img-wrapper">
                                    <img src="{{ $service->resolveImageUrl($service->image) }}" alt="{{ $service->name }}">
                                    <span class="badge badge-top bg-primary px-3 py-2 rounded-pill text-uppercase" style="font-size:.7rem;">Interior Service</span>
                                </div>
                                <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                    <div>
                                        <span class="text-uppercase fw-bold text-muted small letter-spacing-1 mb-2 d-block">{{ $service->subtitle }}</span>
                                        <h3 class="fw-bold text-dark fs-4 mb-3">{{ $service->name }}</h3>
                                        <p class="text-secondary small mb-4">{{ Str::limit($service->description, 120, '...') }}</p>
                                    </div>
                                    <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                        <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline-primary rounded-pill px-3 py-2 small">View Service Details &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $renderedCount++; @endphp
                    @endif
                @endforeach

                @foreach($products as $product)
                    @if($renderedCount < 3)
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="catalog-item-card card border-0 w-100 d-flex flex-column justify-content-between">
                                <div class="card-img-wrapper">
                                    <img src="{{ $product->resolveImageUrl($product->image) }}" alt="{{ $product->name }}">
                                    <span class="badge badge-top bg-dark px-3 py-2 rounded-pill text-uppercase" style="font-size:.7rem;">Organic Product</span>
                                </div>
                                <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                    <div>
                                        <span class="text-uppercase fw-bold text-muted small letter-spacing-1 mb-2 d-block">{{ !empty($product->highlights) ? $product->highlights[0] : 'Bespoke Craftsmanship' }}</span>
                                        <h3 class="fw-bold text-dark fs-4 mb-3">{{ $product->name }}</h3>
                                        <p class="text-secondary small mb-4">{{ Str::limit($product->description, 120, '...') }}</p>
                                    </div>
                                    <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary rounded-pill px-3 py-2 small text-white">View Product Specs &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $renderedCount++; @endphp
                    @endif
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('services.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-sm">View All Services & Products</a>
            </div>
        </div>
    </section>

    {{-- Why Lumos Section --}}
    <section class="why-lumos-section py-5 my-lg-5" id="why-lumos">
        <div class="container py-lg-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="why-lumos-content">
                        <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">{{ $settings['home_why_choose_eyebrow'] ?? 'Why Lumos?' }}</span>
                        <h2 class="display-5 fw-bold text-dark mb-4">{!! preg_replace('/##(.*?)##/', '<span class="text-primary">$1</span>', $settings['home_why_choose_title'] ?? 'Dedicated to Your Baby\'s First Room') !!}</h2>
                        <p class="text-muted mb-5 fs-5">
                            {{ $settings['home_why_choose_desc'] ?? 'As Sri Lanka\'s only specialized nursery design studio, we understand that a baby\'s room is more than just furniture—it\'s a sanctuary for growth, sleep, and dreams.' }}
                        </p>

                        <div class="feature-list">
                            <div class="feature-item d-flex mb-4">
                                <div class="feature-icon-wrapper me-3">
                                    <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $settings['home_feat1_title'] ?? 'Safety-First Design' }}</h5>
                                    <p class="text-secondary mb-0">{{ $settings['home_feat1_desc'] ?? 'From non-toxic finishes to rounded furniture edges, every detail is engineered with your baby\'s safety as our highest priority.' }}</p>
                                </div>
                            </div>
                            <div class="feature-item d-flex mb-4">
                                <div class="feature-icon-wrapper me-3">
                                    <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $settings['home_feat2_title'] ?? 'Bespoke Craftsmanship' }}</h5>
                                    <p class="text-secondary mb-0">{{ $settings['home_feat2_desc'] ?? 'We don\'t do generic. Our furniture and decor are custom-crafted to fit your specific space, theme, and budget.' }}</p>
                                </div>
                            </div>
                            <div class="feature-item d-flex">
                                <div class="feature-icon-wrapper me-3">
                                    <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $settings['home_feat3_title'] ?? 'Expert Consultation' }}</h5>
                                    <p class="text-secondary mb-0">{{ $settings['home_feat3_desc'] ?? 'Our designers work closely with you to understand your vision, offering professional advice on lighting, flow, and aesthetics.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="why-lumos-image-grid position-relative">
                        <img src="{{ isset($settings['home_why_choose_image']) ? asset('storage/' . $settings['home_why_choose_image']) : 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=800' }}" alt="Lumos Premium Nursery" class="img-fluid rounded-4 shadow-lg">
                        <div class="floating-badge bg-white p-3 rounded-4 shadow-sm position-absolute bottom-0 start-0 m-4 d-none d-md-flex align-items-center gap-3">
                            <div class="icon bg-success bg-opacity-10 text-success rounded-circle p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div>
                                <p class="fw-bold mb-0 text-dark">{{ $settings['home_why_choose_badge_value'] ?? '100% Recommendation' }}</p>
                                <p class="very-small text-muted mb-0">{{ $settings['home_why_choose_badge_text'] ?? 'Based on recent projects' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Social Square (Reviews & Social Feed) Section --}}
    <section class="social-square-section py-5" id="social-square">
        <div class="container py-lg-4">
            <div class="row g-3 mb-5 align-items-stretch" id="socialGallery">
                @php
                    $renderedIndex = 0;
                    $titleCardRendered = false;
                @endphp
                @forelse($gridItems as $index => $item)
                    @if($renderedIndex === 5 && !$titleCardRendered)
                        {{-- Central Title Card after 5 posts --}}
                        <div class="col-12 col-lg-6 d-flex align-items-center">
                            <div class="gallery-title-card p-4 p-lg-5 w-100 rounded-4 text-center d-flex flex-column justify-content-center h-100">
                                <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill mx-auto">Social Square</span>
                                <h2 class="display-4 fw-bold text-dark">Tiny Dreams Gallery</h2>
                                <p class="text-muted mx-auto mb-0 fs-5" style="max-width: 450px;">
                                    Explore our latest nursery setups and see real stories from real parents.
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('services.index') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold">View All Reviews & Stories</a>
                                </div>
                            </div>
                        </div>
                        @php $titleCardRendered = true; @endphp
                    @endif

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                            data-type="{{ $item['type'] }}"
                            data-images='{!! json_encode($item['images'] ?? [$item['image']]) !!}'
                            data-name="{{ $item['name'] }}"
                            data-review="{{ $item['text'] }}"
                            data-stars="{{ $item['stars'] }}">
                            <div class="post-img-wrapper">
                                <img src="{{ $item['image'] }}" class="img-fluid" alt="{{ $item['name'] }}">
                                <div class="post-category-badge {{ $item['type'] === 'social' ? 'bg-dark' : '' }}">
                                    {{ ucfirst($item['type']) }}
                                </div>
                                <div class="post-overlay">
                                    <div class="post-content p-3 text-white">
                                        <p class="small mb-1 fw-bold">{{ $item['name'] }}</p>
                                        <p class="very-small mb-0 opacity-75">"{{ Str::limit($item['text'], 60) }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $renderedIndex++; @endphp
                @empty
                    {{-- Central Title Card if empty --}}
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No Social Square posts configured yet.</h4>
                    </div>
                @endforelse
                
                @if(!$titleCardRendered && count($gridItems) < 5)
                    {{-- Render Title Card at the end if we had fewer than 5 items --}}
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="gallery-title-card p-4 p-lg-5 w-100 rounded-4 text-center d-flex flex-column justify-content-center h-100">
                            <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill mx-auto">Social Square</span>
                            <h2 class="display-4 fw-bold text-dark">Tiny Dreams Gallery</h2>
                            <p class="text-muted mx-auto mb-0 fs-5" style="max-width: 450px;">
                                Explore our latest nursery setups and see real stories from real parents.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('services.index') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold">View All Reviews & Stories</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Reusable Inquiry Section --}}
    @include('frontend.partials.inquiry')
@endsection

@section('modal')
    @include('frontend.partials.gallery_modal')
@endsection
