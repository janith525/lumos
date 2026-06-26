@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/service_detail.scss')
@section('classes_body', 'service-detail-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => $service['title'],
        'bgImage' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Services & Products', 'url' => route('services.index')],
            ['label' => 'Service Detail']
        ]
    ])

    {{-- Main Service Details --}}
    <section class="service-detail-section py-5 my-5">
        <div class="container">
            <div class="row g-5">

                {{-- Left Side: Main Showcase --}}
                <div class="col-lg-7 d-flex flex-column gap-5">

                    {{-- Main Service Description Card --}}
                    <div class="service-main-card p-4 p-lg-5">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Interior Styling Service</span>
                        <h2 class="display-6 fw-bold text-dark mb-3">{{ $service['title'] }}</h2>
                        <p class="lead text-secondary fw-semibold mb-4">{{ $service['tagline'] }}</p>

                        {{-- Timeline and Fee details --}}
                        @if(!empty($service['project_timeline']) || !empty($service['consultation_fee']))
                            <div class="d-flex gap-3 mb-4 flex-wrap">
                                @if(!empty($service['project_timeline']))
                                    <div class="px-3 py-2 bg-light border rounded-3 d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#66BCBA" class="text-primary" viewBox="0 0 16 16"><path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/><path d="M14 0a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12zM2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/></svg>
                                        <span class="small fw-bold text-dark">Timeline: {{ $service['project_timeline'] }}</span>
                                    </div>
                                @endif
                                @if(!empty($service['consultation_fee']))
                                    <div class="px-3 py-2 bg-light border rounded-3 d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#66BCBA" class="text-success" viewBox="0 0 16 16"><path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3zm14 0a.5.5 0 0 0-.5-.5h-13a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V3z"/><path d="M8 5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM6.5 6.5A1.5 1.5 0 1 1 8 8 1.5 1.5 0 0 1 6.5 6.5z"/></svg>
                                        <span class="small fw-bold text-dark">Consultation Fee: {{ $service['consultation_fee'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @include('frontend.partials.image_thumbnails', [
                            'mainImage' => $service['image'],
                            'gallery' => $service['gallery'] ?? [],
                            'uniqueId' => 'serviceGalleryMain'
                        ])

                        <h4 class="fw-bold text-dark mb-3 mt-4">Service Scope & Quality Standards</h4>
                        <div class="text-secondary fs-6 mb-4" style="line-height: 1.8;">
                            {!! $service['description'] !!}
                        </div>

                        {{-- Package Inclusions List --}}
                        @if(!empty($service['inclusions']) && count($service['inclusions']) > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h4 class="fw-bold text-dark mb-3">What's Included in This Package</h4>
                                <div class="row g-2">
                                    @foreach($service['inclusions'] as $inc)
                                        @if(filled($inc))
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#66BCBA" class="bi bi-check-circle-fill flex-shrink-0" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <span class="small text-dark fw-semibold">{{ $inc }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Right Side: Related Products --}}
                <div class="col-lg-5 d-flex flex-column gap-5">

                    {{-- Related Products Column --}}
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Furniture Spec</span>
                        <h3 class="fw-bold text-dark mb-4 fs-3">Featured Cribs & Pieces</h3>

                        <div class="d-flex flex-column gap-3">
                            @forelse($relatedProducts as $prod)
                                <a href="{{ route('products.show', $prod['slug']) }}" class="related-product-item d-flex gap-3 align-items-center p-3 text-decoration-none">
                                    <div class="prod-thumb-wrapper">
                                        <img src="{{ $prod['image'] }}" alt="{{ $prod['title'] }}">
                                    </div>
                                    <div class="flex-grow-1">
                                            <h5 class="fw-bold text-dark mb-1 fs-6">{{ $prod['title'] }}</h5>
                                            <span class="text-muted small d-block mb-1">{{ $prod['tagline'] }}</span>
                                        </div>
                                    <div class="text-primary fw-bold fs-5 px-2">&rarr;</div>
                                </a>
                            @empty
                                <p class="text-muted">No related pieces found.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick Inquiry Form (inline card) --}}
                    <div class="detail-inquiry-card p-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Quick Inquiry</span>
                        <h4 class="fw-bold text-dark mb-1 fs-4">Interested? Let's Talk.</h4>
                        <p class="text-secondary small mb-4">Drop us a message and we'll get back within 24 hours.</p>

                        <form class="quick-inquiry-form" action="#" method="POST" novalidate>
                            @csrf
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <label class="form-label fw-semibold text-dark small mb-1">Your Name</label>
                                    <input type="text" name="name" class="form-control qi-input" placeholder="E.g. Priyani Perera" required>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark small mb-1">Phone / WhatsApp</label>
                                    <input type="tel" name="phone" class="form-control qi-input" placeholder="+94 7X XXX XXXX" required>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark small mb-1">Service of Interest</label>
                                    <input type="text" name="subject" class="form-control qi-input" value="{{ $service['title'] }}" readonly>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark small mb-1">Your Message</label>
                                    <textarea name="message" class="form-control qi-input" rows="3" placeholder="Tell us about your nursery vision..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold w-100">
                                    Send Inquiry
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ms-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- Client Reviews & Showcase Gallery — Social Square Style   --}}
    {{-- ========================================================= --}}
    <section class="social-square-section service-social-square py-5" id="service-reviews">
        <div class="container py-lg-4">

            <div class="row g-3 align-items-stretch" id="serviceGallery">

                {{-- Gallery Photos as social posts --}}
                @foreach($service['gallery'] as $index => $img)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="social-post-card cursor-pointer"
                             data-bs-toggle="modal" data-bs-target="#reviewModal"
                             data-type="post"
                             data-name="Lumos Custom Installation"
                             data-review="Detailing the premium quality craftsmanship, safety alignments, and sleep-promoting illumination of this {{ $service['title'] }} project."
                             data-images='["{{ $img }}"]'
                             data-stars="5">
                            <div class="post-img-wrapper">
                                <img src="{{ $img }}" class="img-fluid" alt="{{ $service['title'] }} Gallery">
                                <div class="post-category-badge bg-dark">Gallery</div>
                                <div class="post-overlay">
                                    <div class="post-content p-3 text-white">
                                        <p class="small mb-1 fw-bold">Lumos Installation</p>
                                        <p class="very-small mb-0 opacity-75">Click to view full detail</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Central Title Card --}}
                <div class="col-12 col-lg-6 d-flex align-items-center">
                    <div class="gallery-title-card p-4 p-lg-5 w-100 rounded-4 text-center d-flex flex-column justify-content-center h-100">
                        <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill mx-auto">Client Stories</span>
                        <h2 class="display-4 fw-bold text-dark">{{ $service['title'] }}</h2>
                        <p class="text-muted mx-auto mb-0 fs-5" style="max-width: 450px;">
                            Real reviews and showcase photos from parents who experienced this service.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('services.index') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold">Explore All Services</a>
                        </div>
                    </div>
                </div>

                {{-- Client Reviews as social posts --}}
                @foreach($service['reviews'] as $rev)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="social-post-card service-review-post cursor-pointer"
                             data-bs-toggle="modal" data-bs-target="#reviewModal"
                             data-type="review"
                             data-name="{{ $rev['name'] }}"
                             data-review="{{ $rev['text'] }}"
                             data-images='["{{ $service['image'] }}"]'
                             data-stars="{{ $rev['stars'] }}">
                            <div class="post-img-wrapper">
                                <img src="{{ $service['image'] }}" class="img-fluid" alt="Review by {{ $rev['name'] }}">
                                <div class="post-category-badge">Review</div>
                                <div class="post-overlay">
                                    <div class="post-content p-3 text-white">
                                        <p class="small mb-1 fw-bold">{{ $rev['name'] }}</p>
                                        <p class="very-small mb-0 opacity-75">"{{ Str::limit($rev['text'], 60) }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- Reusable Gallery Lightbox Popup Modal HTML & JS Script --}}
    @include('frontend.partials.gallery_modal')


    {{-- Reusable Inquiry CTA --}}
    @include('frontend.partials.inquiry')
@endsection
