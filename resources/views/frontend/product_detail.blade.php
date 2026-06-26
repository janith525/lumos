@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/product_detail.scss')
@section('classes_body', 'product-detail-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => $product['title'],
        'bgImage' => 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Services & Products', 'url' => route('services.index')],
            ['label' => 'Product Detail']
        ]
    ])

    {{-- Main Product Specs --}}
    <section class="product-detail-section py-5 my-5">
        <div class="container">
            <div class="row g-5">

                {{-- Left Side: Main Spec Card --}}
                <div class="col-lg-7 d-flex flex-column gap-5">

                    {{-- Main Product Description Card --}}
                    <div class="product-main-card p-4 p-lg-5">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                            <div>
                                <span class="badge bg-dark text-white mb-2 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Bespoke Collection</span>
                                <h2 class="display-6 fw-bold text-dark mb-1">{{ $product['title'] }}</h2>
                                <p class="lead text-secondary fw-semibold mb-0">{{ $product['tagline'] }}</p>
                            </div>
                            <div class="text-lg-end">
                                {{-- Price intentionally removed from product card per design --}}
                            </div>
                        </div>

                        @include('frontend.partials.image_thumbnails', [
                            'mainImage' => $product['image'],
                            'gallery' => $product['gallery'] ?? [],
                            'uniqueId' => 'productGallery'
                        ])

                        <h4 class="fw-bold text-dark mb-3">Material & Craftsmanship Specs</h4>
                        <div class="text-secondary fs-6 mb-0" style="line-height: 1.8;">
                            {!! $product['description'] !!}
                        </div>

                        {{-- Specifications Table --}}
                        @if(!empty($product['dimensions']) || !empty($product['material']) || !empty($product['safety_standards']) || !empty($product['age_range']) || !empty($product['lead_time']))
                            <div class="mt-4 pt-4 border-top">
                                <h4 class="fw-bold text-dark mb-3">Specifications Sheet</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle border-0" style="border-radius: 12px; overflow: hidden; background: rgba(0, 0, 0, 0.02);">
                                        <tbody>
                                            @if(!empty($product['dimensions']))
                                                <tr>
                                                    <th class="ps-3 py-3 text-secondary text-uppercase fw-bold" style="font-size: 12px; width: 35%;">Dimensions</th>
                                                    <td class="py-3 text-dark fw-medium" style="font-size: 14px;">{{ $product['dimensions'] }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($product['material']))
                                                <tr>
                                                    <th class="ps-3 py-3 text-secondary text-uppercase fw-bold" style="font-size: 12px; width: 35%;">Material & Finish</th>
                                                    <td class="py-3 text-dark fw-medium" style="font-size: 14px;">{{ $product['material'] }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($product['safety_standards']))
                                                <tr>
                                                    <th class="ps-3 py-3 text-secondary text-uppercase fw-bold" style="font-size: 12px; width: 35%;">Safety Standards</th>
                                                    <td class="py-3 text-dark fw-medium" style="font-size: 14px;">
                                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2.5 py-1.5" style="border-radius: 6px; font-size: 12px;">{{ $product['safety_standards'] }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(!empty($product['age_range']))
                                                <tr>
                                                    <th class="ps-3 py-3 text-secondary text-uppercase fw-bold" style="font-size: 12px; width: 35%;">Suitable Age</th>
                                                    <td class="py-3 text-dark fw-medium" style="font-size: 14px;">{{ $product['age_range'] }}</td>
                                                </tr>
                                            @endif
                                            @if(!empty($product['lead_time']))
                                                <tr>
                                                    <th class="ps-3 py-3 text-secondary text-uppercase fw-bold" style="font-size: 12px; width: 35%;">Lead Time</th>
                                                    <td class="py-3 text-dark fw-medium" style="font-size: 14px;">
                                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-2.5 py-1.5" style="border-radius: 6px; font-size: 12px;">{{ $product['lead_time'] }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Right Side: Related Interior Styling Services --}}
                <div class="col-lg-5 d-flex flex-column gap-5">

                    {{-- Related Services Column --}}
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Related Room Styling</span>
                        <h3 class="fw-bold text-dark mb-4 fs-3">Matching Styling Plans</h3>

                        <div class="d-flex flex-column gap-3">
                            @forelse($relatedServices as $serv)
                                <a href="{{ route('services.show', $serv['slug']) }}" class="related-service-card d-flex gap-3 align-items-center p-3 text-decoration-none">
                                    <div class="service-thumb">
                                        <img src="{{ $serv['image'] }}" alt="{{ $serv['title'] }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold text-dark mb-1 fs-6">{{ $serv['title'] }}</h5>
                                        <span class="text-muted small d-block">{{ $serv['tagline'] }}</span>
                                    </div>
                                    <div class="text-primary fw-bold fs-5 px-2">&rarr;</div>
                                </a>
                            @empty
                                <p class="text-muted">No matching interior styling plan found.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick Inquiry Form (inline card) --}}
                    <div class="detail-inquiry-card p-4">
                        <span class="badge bg-dark text-white mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Quick Inquiry</span>
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
                                    <label class="form-label fw-semibold text-dark small mb-1">Product of Interest</label>
                                    <input type="text" name="subject" class="form-control qi-input" value="{{ $product['title'] }}" readonly>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-dark small mb-1">Your Message</label>
                                    <textarea name="message" class="form-control qi-input" rows="3" placeholder="Tell us about your requirements..."></textarea>
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

    {{-- ============================================================ --}}
    {{-- Detail Showcase Gallery — Social Square Style               --}}
    {{-- ============================================================ --}}
    <section class="social-square-section product-social-square py-5" id="product-showcase">
        <div class="container py-lg-4">

            <div class="row g-3 align-items-stretch" id="productGallery">

                {{-- Central Title Card first on this page --}}
                <div class="col-12 col-lg-6 d-flex align-items-center order-lg-2">
                    <div class="gallery-title-card p-4 p-lg-5 w-100 rounded-4 text-center d-flex flex-column justify-content-center h-100">
                        <span class="badge bg-dark text-white mb-3 px-3 py-2 rounded-pill mx-auto">Detail Showcase</span>
                        <h2 class="display-4 fw-bold text-dark">Craftsmanship Gallery</h2>
                        <p class="text-muted mx-auto mb-0 fs-5" style="max-width: 450px;">
                            Up-close photos of the joinery, finishes, and child-safe details that make every {{ $product['title'] }} piece exceptional.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('services.index', ['type' => 'products']) }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold">View All Products</a>
                        </div>
                    </div>
                </div>

                {{-- Gallery Photos as social posts --}}
                @foreach($product['gallery'] as $index => $img)
                    <div class="col-6 col-md-4 col-lg-3 order-lg-{{ $index < 2 ? 1 : 3 }}">
                        <div class="social-post-card cursor-pointer"
                             data-bs-toggle="modal" data-bs-target="#reviewModal"
                             data-type="post"
                             data-name="Lumos Bespoke Details"
                             data-review="Detailing the premium quality joinery, child-safe soft-close drawer slides, and natural organic wood oil coat finish of the {{ $product['title'] }}."
                             data-images='["{{ $img }}"]'
                             data-stars="5">
                            <div class="post-img-wrapper">
                                <img src="{{ $img }}" class="img-fluid" alt="{{ $product['title'] }} Detail">
                                <div class="post-category-badge bg-dark">Detail</div>
                                <div class="post-overlay">
                                    <div class="post-content p-3 text-white">
                                        <p class="small mb-1 fw-bold">Lumos Craftsmanship</p>
                                        <p class="very-small mb-0 opacity-75">Click to view full detail</p>
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
