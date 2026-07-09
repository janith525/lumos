@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/gallery.scss')
@section('classes_body', 'gallery-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => "Sri Lanka's Luxury Nursery & Baby Room Portfolio",
        'bgImage' => !empty($settings['gallery_banner_image']) ? (str_starts_with($settings['gallery_banner_image'], 'http') ? $settings['gallery_banner_image'] : asset('storage/' . $settings['gallery_banner_image'])) : 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Gallery']
        ]
    ])

    {{-- Gallery Section --}}
    <section class="gallery-page-section py-5 my-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Our Showcase</span>
                    <h2 class="display-6 fw-bold text-dark mb-3">Explore Our Tiny Creations</h2>
                    <p class="lead text-muted max-w-600 mx-auto">
                        Filter through our finished rooms, bespoke child-safe furniture pieces, and custom lighting setups designed for families in Sri Lanka.
                    </p>
                </div>
            </div>

            {{-- Filter Group --}}
            <div class="row mb-5">
                <div class="col-12">
                    <div class="filter-btn-group">
                        <button class="gallery-filter-btn active" data-filter="all">Show All</button>
                        <button class="gallery-filter-btn" data-filter="nursery">Baby Nurseries</button>
                        <button class="gallery-filter-btn" data-filter="furniture">Bespoke Furniture</button>
                        <button class="gallery-filter-btn" data-filter="playroom">Kids Playrooms</button>
                        <button class="gallery-filter-btn" data-filter="backdrop">Backdrops & Decor</button>
                    </div>
                </div>
            </div>

            {{-- Gallery Grid --}}
            <div class="row g-4 gallery-grid" id="galleryGrid">
                @forelse($galleryItems as $item)
                    <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="{{ $item->category }}">
                        <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                            data-type="{{ $item->type }}"
                            data-images='{!! json_encode($item->galleryImageUrls() ?: [$item->primaryImageUrl()]) !!}'
                            data-name="{{ $item->type === 'review' ? ($item->review_author ?? $item->title) : $item->title }}" 
                            data-review="{{ $item->review_content ?? '' }}"
                            data-stars="{{ $item->stars }}">
                            <div class="post-img-wrapper">
                                <img src="{{ $item->primaryImageUrl() }}" alt="{{ $item->title }}">
                                <div class="post-category-badge {{ $item->type === 'social' ? 'bg-dark text-white' : '' }}">{{ ucfirst($item->category) }}</div>
                                <div class="post-overlay">
                                    <div class="post-content p-3 text-white">
                                        <p class="small mb-1 fw-bold">{{ $item->title }}</p>
                                        <p class="very-small mb-0 opacity-75">{{ $item->subtitle ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">No gallery showcase items available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Reusable Inquiry Section --}}
    @include('frontend.partials.inquiry')
@endsection

@section('modal')
    @include('frontend.partials.gallery_modal')
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.gallery-filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class
            filterButtons.forEach(b => b.classList.remove('active'));
            // Add active class
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');
                
                if (filterValue === 'all' || category === filterValue) {
                    item.classList.remove('hidden');
                    // Add standard Bootstrap transition animations
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.classList.add('hidden');
                    }, 300);
                }
            });
        });
    });
});
</script>
@endsection
