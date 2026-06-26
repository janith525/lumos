@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/services_listing.scss')
@section('classes_body', 'services-listing-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => "Explore Our Luxury Nursery Designs & Organic Products",
        'bgImage' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Services & Products']
        ]
    ])

    {{-- Catalog Grid Section --}}
    <section class="catalog-section py-5 my-5">
        <div class="container">

            {{-- Category Filter Navigation --}}
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Lumos Catalogue</span>
                    <h2 class="display-6 fw-bold text-dark mb-4">Dream Spaces & Handcrafted Pieces</h2>

                    <div class="d-flex justify-content-center flex-wrap gap-3 mt-2">
                        <a href="{{ route('services.index', ['type' => 'all']) }}"
                           class="catalog-filter-btn {{ $currentType === 'all' ? 'active' : '' }}">
                           Show All
                        </a>
                        <a href="{{ route('services.index', ['type' => 'services']) }}"
                           class="catalog-filter-btn {{ $currentType === 'services' ? 'active' : '' }}">
                           Interior Services
                        </a>
                        <a href="{{ route('services.index', ['type' => 'products']) }}"
                           class="catalog-filter-btn {{ $currentType === 'products' ? 'active' : '' }}">
                           Bespoke Kids Products
                        </a>
                    </div>
                </div>
            </div>

            {{-- Grid of Items --}}
            <div class="row g-4 justify-content-center">
                @forelse($items as $item)
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="catalog-item-card card border-0 w-100 d-flex flex-column justify-content-between">

                            {{-- Image Showcase --}}
                            <div class="card-img-wrapper">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">

                                {{-- Badge --}}
                                @if($item['type'] === 'service')
                                    <span class="badge badge-top bg-primary px-3 py-2 rounded-pill text-uppercase fs-6">
                                        Interior Service
                                    </span>
                                @else
                                    <span class="badge badge-top bg-dark px-3 py-2 rounded-pill text-uppercase fs-6">
                                        Organic Product
                                    </span>
                                @endif
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <span class="text-uppercase fw-bold text-muted small letter-spacing-1 mb-2 d-block">
                                        {{ $item['tagline'] }}
                                    </span>
                                    <h3 class="fw-bold text-dark fs-4 mb-3">{{ $item['title'] }}</h3>
                                    <p class="text-secondary small mb-4">
                                        {{ Str::limit($item['description'], 120, '...') }}
                                    </p>
                                </div>

                                {{-- Action / Footer --}}
                                <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                    @if($item['type'] === 'service')
                                        <a href="{{ route('services.show', $item['slug']) }}" class="btn btn-outline-primary rounded-pill px-3 py-2 small">
                                            View Service Details &rarr;
                                        </a>
                                    @else
                                        <a href="{{ route('products.show', $item['slug']) }}" class="btn btn-primary rounded-pill px-3 py-2 small text-white">
                                            View Product Specs &rarr;
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="text-muted mb-3"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            <h4 class="fw-bold text-dark">No Catalogue Items Found</h4>
                            <p class="text-secondary">Please clear your active filters or check back later.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Bar --}}
            <div class="catalog-pagination-bar mt-5 pt-4">
                @if($items->hasPages())
                    <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-4 w-100">
                        {{-- Result Count on Left --}}
                        <div class="catalog-result-count text-muted small">
                            Showing <strong class="text-dark">{{ $items->firstItem() }}</strong> to <strong class="text-dark">{{ $items->lastItem() }}</strong> of <strong class="text-dark">{{ $items->total() }}</strong> results
                        </div>

                        {{-- Pagination Links on Right --}}
                        <div class="catalog-pagination">
                            {!! $items->appends(request()->query())->links('vendor.pagination.custom-bootstrap-5') !!}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>

    {{-- Reusable Inquiry CTA --}}
    @include('frontend.partials.inquiry')
@endsection
