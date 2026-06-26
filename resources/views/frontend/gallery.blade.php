@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/gallery.scss')
@section('classes_body', 'gallery-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => "Sri Lanka's Luxury Nursery & Baby Room Portfolio",
        'bgImage' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1600',
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
                
                {{-- Item 1: Royal Pastel Nursery --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="nursery">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="review"
                        data-images='["https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200", "https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Dilani S. (Colombo 07)" 
                        data-review="Absolutely in love with the Royal Pastel Nursery. The organic wood finish is incredibly safe, and the round crib is the centerpiece of the room!"
                        data-stars="5">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=600" alt="Royal Pastel Nursery">
                            <div class="post-category-badge">Nursery</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Royal Pastel Nursery</p>
                                    <p class="very-small mb-0 opacity-75">Completed Nursery | Colombo 07</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 2: Starry Sky Backdrop --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="backdrop">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="social"
                        data-images='["https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Starry Sky Backdrop" 
                        data-review="Our signature backlit constellation board uses warm, baby-safe low-voltage LED lights to create a soothing, calm sleep environment."
                        data-stars="0">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=600" alt="Starry Sky Backdrop">
                            <div class="post-category-badge">Decor</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Starry Constellation Board</p>
                                    <p class="very-small mb-0 opacity-75">Custom Backlit Decor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 3: Child-Safe Organic Wood Crib --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="furniture">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="review"
                        data-images='["https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=1200", "https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Kavinda W. (Kandy)" 
                        data-review="The rounded edges on all furniture give us total peace of mind. Exceptional craftsmanship by the Lumos team!"
                        data-stars="5">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=600" alt="Organic Wood Crib">
                            <div class="post-category-badge">Furniture</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Bespoke Organic Crib</p>
                                    <p class="very-small mb-0 opacity-75">Child-Safe Ergonomic Furniture</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 4: Montessori House Bed Playroom --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="playroom">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="social"
                        data-images='["https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Montessori Play Area" 
                        data-review="Fostering ultimate creativity and independence. Our Montessori house beds are built from solid non-toxic hardwood."
                        data-stars="0">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=600" alt="Montessori Playroom">
                            <div class="post-category-badge">Playroom</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Montessori House Suite</p>
                                    <p class="very-small mb-0 opacity-75">Interactive Play Area</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 5: Safari Theme Nursery --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="nursery">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="review"
                        data-images='["https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Nalaka P. (Negombo)" 
                        data-review="The custom jungle wall vinyls and matching cotton rugs completely changed the nursery atmosphere. Absolutely premium!"
                        data-stars="5">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=600" alt="Safari Theme Nursery">
                            <div class="post-category-badge">Nursery</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Safari Theme Baby Room</p>
                                    <p class="very-small mb-0 opacity-75">Theme Development | Negombo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 6: Scandinavian Toy Cabinet --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="furniture">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="social"
                        data-images='["https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Scandinavian Storage Unit" 
                        data-review="Organize with absolute style. Soft-close hinges and completely round edges ensure ultimate baby-proofing."
                        data-stars="0">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=600" alt="Scandinavian storage">
                            <div class="post-category-badge">Furniture</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Soft-Close Storage Chest</p>
                                    <p class="very-small mb-0 opacity-75">Premium Baby Proofing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 7: Cloud Hot Air Balloon Backdrops --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="backdrop">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="review"
                        data-images='["https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Ruwanthi D. (Rajagiriya)" 
                        data-review="Our little girl stares at the cloud backdrop every single evening before sleeping. It is so soothing!"
                        data-stars="5">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=600" alt="Cloud backdrop">
                            <div class="post-category-badge">Decor</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Cloud Backdrop Motifs</p>
                                    <p class="very-small mb-0 opacity-75">Backlit Soft Lighting</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 8: Cozy Reading Teepee --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="playroom">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="social"
                        data-images='["https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Cozy Reading Teepee" 
                        data-review="Combining high-density soft foam padding with premium washed-cotton linens for the ultimate interactive play corner."
                        data-stars="0">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=600" alt="Cozy Reading Teepee">
                            <div class="post-category-badge">Playroom</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Interactive Reading Teepee</p>
                                    <p class="very-small mb-0 opacity-75">Interactive Play corners</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 9: Modern Changing Table --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="furniture">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="review"
                        data-images='["https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Mahela J. (Battaramulla)" 
                        data-review="Highly functional changing drawer system with premium rounded dividers. Best investment we made!"
                        data-stars="5">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=600" alt="Changing table">
                            <div class="post-category-badge">Furniture</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Bespoke Changing Chest</p>
                                    <p class="very-small mb-0 opacity-75">Multi-Functional Furniture</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 10: Warm Boho Nursery --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="nursery">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="social"
                        data-images='["https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Warm Neutral Boho Suite" 
                        data-review="Crafted with natural materials, light oak woods, and high-quality premium linen fabrics for ultimate child safety."
                        data-stars="0">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=600" alt="Boho Nursery">
                            <div class="post-category-badge">Nursery</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Boho Warm-Neutral Room</p>
                                    <p class="very-small mb-0 opacity-75">Natural Aesthetics Setup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 11: Constellation Ceiling motifs --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="backdrop">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="review"
                        data-images='["https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Kanishka D. (Nugegoda)" 
                        data-review="Lumos backlit ceiling motifs act as a beautiful soft nightlight, helping our baby settle into a deep sleep."
                        data-stars="5">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=600" alt="Ceiling decor">
                            <div class="post-category-badge">Decor</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Constellation Ceiling Panels</p>
                                    <p class="very-small mb-0 opacity-75">Backlit Ceiling Motifs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item 12: Pastel Soft Gym --}}
                <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="playroom">
                    <div class="social-post-card cursor-pointer" data-bs-toggle="modal" data-bs-target="#reviewModal"
                        data-type="social"
                        data-images='["https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200"]'
                        data-name="Pastel Activity Suite" 
                        data-review="Safe, fun, and fully sanitizable. Custom padded flooring and activity centers designed with high-density premium foams."
                        data-stars="0">
                        <div class="post-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=600" alt="Pastel play gym">
                            <div class="post-category-badge">Playroom</div>
                            <div class="post-overlay">
                                <div class="post-content p-3 text-white">
                                    <p class="small mb-1 fw-bold">Padded Play Gym</p>
                                    <p class="very-small mb-0 opacity-75">Child-Safe Playroom suite</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
