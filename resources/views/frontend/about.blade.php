@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/about.scss')
@section('classes_body', 'about-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => $settings['about_banner_title'] ?? "Sri Lanka's Pioneer Luxury Nursery & Kids Room Designers",
        'bgImage' => !empty($settings['about_banner_image']) ? (str_starts_with($settings['about_banner_image'], 'http') ? $settings['about_banner_image'] : asset('storage/' . $settings['about_banner_image'])) : 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'About Us']
        ]
    ])

    {{-- Story Section --}}
    <section class="about-story-section py-5 my-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="story-image-grid position-relative">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="image-box box-1 mb-3">
                                    <img src="{{ !empty($settings['about_story_image1']) ? (str_starts_with($settings['about_story_image1'], 'http') ? $settings['about_story_image1'] : asset('storage/' . $settings['about_story_image1'])) : 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=800' }}" class="img-fluid rounded-4 shadow-sm" alt="Bespoke Crib Design">
                                </div>
                                <div class="image-box box-2">
                                    <img src="{{ !empty($settings['about_story_image2']) ? (str_starts_with($settings['about_story_image2'], 'http') ? $settings['about_story_image2'] : asset('storage/' . $settings['about_story_image2'])) : 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=800' }}" class="img-fluid rounded-4 shadow-sm" alt="Nursery Textile Details">
                                </div>
                            </div>
                            <div class="col-6 pt-4">
                                <div class="image-box box-3 mb-3">
                                    <img src="{{ !empty($settings['about_story_image3']) ? (str_starts_with($settings['about_story_image3'], 'http') ? $settings['about_story_image3'] : asset('storage/' . $settings['about_story_image3'])) : 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=800' }}" class="img-fluid rounded-4 shadow-sm" alt="Magic Lighting Motif">
                                </div>
                                <div class="experience-card bg-primary text-white p-4 rounded-4 shadow-lg text-center position-relative overflow-hidden">
                                    <div class="shape-blob position-absolute bg-white opacity-10 rounded-circle shape-blob-about-story"></div>
                                    <span class="display-4 fw-bold d-block">1st</span>
                                    <p class="small mb-0 text-uppercase letter-spacing-1">Nursery Design Studio in Sri Lanka</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="story-content-wrapper ps-lg-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">{{ $settings['about_story_eyebrow'] ?? 'How It All Began' }}</span>
                        <h2 class="display-5 fw-bold text-dark mb-4">{!! preg_replace('/##(.*?)##/', '<span class="text-primary">$1</span>', $settings['about_story_title'] ?? 'Crafting Magical Sanctuaries Since the Beginning') !!}</h2>
                        <p class="lead text-muted mb-4">
                            {{ $settings['about_story_lead'] ?? 'Lumos was born out of a simple, heartfelt realization: every newborn deserves a safe, soothing, and incredibly magical environment to grow, play, and dream.' }}
                        </p>
                        <p class="text-secondary mb-4">
                            {{ $settings['about_story_body1'] ?? "As parents, we noticed a critical gap in Sri Lanka's interior landscape. While general house design was thriving, no studio focused strictly on the unique spatial psychology, non-toxic materials, and specialized developmental aesthetics of babies." }}
                        </p>
                        <p class="text-secondary mb-5">
                            {{ $settings['about_story_body2'] ?? "We set out to change that. What started as a tiny team of designers and skilled carpenters crafting custom rounded cribs has blossomed into Sri Lanka's pioneer nursery design studio. Today, we handle full room transformations, custom furniture, safety lighting, and premium textiles—fusing ultimate safety with high-end luxury." }}
                        </p>
                        
                        <div class="row g-4 border-top pt-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon bg-success bg-opacity-10 text-success rounded-circle p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0">100% Non-Toxic Paints</h6>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon bg-success bg-opacity-10 text-success rounded-circle p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0">Custom Child Ergonomics</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="about-stats-section py-5 bg-light my-5 position-relative overflow-hidden" id="about-stats">
        <div class="position-absolute bg-primary opacity-5 rounded-circle shape-decor-1"></div>
        <div class="position-absolute bg-secondary opacity-5 rounded-circle shape-decor-2"></div>

        <div class="container py-4 position-relative z-3">
            <div class="row g-4 text-center">
                {{-- Stat 1 --}}
                <div class="col-md-3 col-6">
                    <div class="stat-card p-4 rounded-4 bg-white shadow-sm border border-white hover-up transition-all">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center icon-size-60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                        <h3 class="display-5 fw-bold text-dark mb-1 font-number"><span class="counter" data-target="150">0</span>+</h3>
                        <p class="text-muted small mb-0 fw-semibold text-uppercase letter-spacing-1">Dream Rooms Built</p>
                    </div>
                </div>
                {{-- Stat 2 --}}
                <div class="col-md-3 col-6">
                    <div class="stat-card p-4 rounded-4 bg-white shadow-sm border border-white hover-up transition-all">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center icon-size-60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <h3 class="display-5 fw-bold text-dark mb-1 font-number"><span class="counter" data-target="100">0</span>%</h3>
                        <p class="text-muted small mb-0 fw-semibold text-uppercase letter-spacing-1">Certified Safety</p>
                    </div>
                </div>
                {{-- Stat 3 --}}
                <div class="col-md-3 col-6">
                    <div class="stat-card p-4 rounded-4 bg-white shadow-sm border border-white hover-up transition-all">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center icon-size-60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <h3 class="display-5 fw-bold text-dark mb-1 font-number"><span class="counter" data-target="8">0</span>+</h3>
                        <p class="text-muted small mb-0 fw-semibold text-uppercase letter-spacing-1">Years Expert Craft</p>
                    </div>
                </div>
                {{-- Stat 4 --}}
                <div class="col-md-3 col-6">
                    <div class="stat-card p-4 rounded-4 bg-white shadow-sm border border-white hover-up transition-all">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center icon-size-60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <h3 class="display-5 fw-bold text-dark mb-1 font-number"><span class="counter" data-target="45">0</span>+</h3>
                        <p class="text-muted small mb-0 fw-semibold text-uppercase letter-spacing-1">Bespoke Motif Designs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Chairman's Message Section --}}
    <section class="chairman-message-section py-5 my-5">
        <div class="container">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div class="row g-0">
                    <div class="col-lg-5 position-relative chairman-img-container">
                        <img src="{{ !empty($settings['about_founder_image']) ? (str_starts_with($settings['about_founder_image'], 'http') ? $settings['about_founder_image'] : asset('storage/' . $settings['about_founder_image'])) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800' }}" class="position-absolute w-100 h-100 object-fit-cover" alt="Chairman, Lumos Studio">
                        <div class="chairman-overlay position-absolute bottom-0 start-0 w-100 p-4 text-white text-shadow-sm d-flex flex-column justify-content-end chairman-overlay-bg">
                            <h4 class="fw-bold mb-1">{{ $settings['about_founder_sig_text'] ?? 'Eng. Janith Wijesinghe' }}</h4>
                            <p class="small mb-0 text-white-50 text-uppercase letter-spacing-1">{{ $settings['about_founder_sig_lbl'] ?? 'Founder & Chairman, Lumos' }}</p>
                        </div>
                    </div>
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-4 p-lg-5">
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">Leadership Thought</span>
                            <h2 class="display-6 fw-bold text-dark mb-4">A Message From Our Chairman</h2>
                            
                            <div class="quote-wrapper position-relative ps-4 border-start border-primary border-3 mb-4">
                                <span class="quote-icon position-absolute top-0 start-0 translate-middle-x text-primary opacity-10 display-1 quote-icon-large">“</span>
                                <p class="lead text-secondary italic mb-0">
                                    "{{ $settings['about_founder_quote'] ?? 'A baby\'s room is where life\'s first discoveries happen. We believe that it shouldn\'t just be safe or organized—it must be an artistic sanctuary that nurtures their imagination, dreams, and well-being. At Lumos, we don\'t merely manufacture furniture; we craft tiny dreams. Our absolute dedication is to deliver Sri Lanka\'s safest, most beautifully tailored rooms so parents can treasure every early milestone without compromise.' }}"
                                </p>
                            </div>
                            
                            <p class="text-muted small">
                                Overseeing a team of dedicated designers, child ergonomists, and master artisans, we pledge to hold the highest safety standards, non-toxic organic materials, and customized excellence in every square inch of our setups.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Vision & Mission Section --}}
    <section class="vision-mission-section py-5 my-5 position-relative overflow-hidden">
        <div class="container">
            <div class="row g-4 justify-content-center">
                {{-- Vision --}}
                <div class="col-md-6">
                    <div class="vision-mission-card p-5 rounded-4 shadow-sm h-100 border border-white hover-up transition-all text-center position-relative overflow-hidden bg-white">
                        <div class="card-bg-gradient position-absolute top-0 start-0 w-100 h-100 opacity-5 vision-gradient-overlay"></div>
                        <div class="icon-wrapper bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center icon-size-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </div>
                        <h3 class="fw-bold text-dark mb-3">Our Vision</h3>
                        <p class="text-secondary mb-0 fs-5 leading-relaxed">
                            To be the premier nursery and kids interior sanctuary design house in South Asia, redefining how parents envision nursery comfort, safety, and magical childhood aesthetics.
                        </p>
                    </div>
                </div>

                {{-- Mission --}}
                <div class="col-md-6">
                    <div class="vision-mission-card p-5 rounded-4 shadow-sm h-100 border border-white hover-up transition-all text-center position-relative overflow-hidden bg-white">
                        <div class="card-bg-gradient position-absolute top-0 start-0 w-100 h-100 opacity-5 mission-gradient-overlay"></div>
                        <div class="icon-wrapper bg-secondary bg-opacity-10 text-secondary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center icon-size-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </div>
                        <h3 class="fw-bold text-dark mb-3">Our Mission</h3>
                        <p class="text-secondary mb-0 fs-5 leading-relaxed">
                            To meticulously craft bespoke, non-toxic, child-safe nursery furniture and magical interactive lighting structures that inspire child development, sleep wellness, and ultimate nursery luxury.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values Section --}}
    <section class="about-values-section py-5 my-5 bg-light position-relative overflow-hidden border-top border-bottom border-light-subtle">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">Our Core Pillars</span>
                    <h2 class="display-5 fw-bold text-dark mb-3">The Principles That Define Lumos</h2>
                    <p class="text-muted fs-5">Everything we engineer, carve, and illuminate is guided by our four absolute standards.</p>
                </div>
            </div>

            <div class="row g-4">
                {{-- Value 1: Safety First --}}
                <div class="col-md-6 col-lg-3">
                    <div class="value-card card border-0 shadow-sm p-4 rounded-4 hover-up transition-all text-center h-100 bg-white">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center icon-size-60 icon-transition-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Uncompromised Safety</h4>
                        <p class="text-secondary small mb-0">We use child-safe certified organic paints and premium non-toxic wood, ensuring all corners are round-finished.</p>
                    </div>
                </div>

                {{-- Value 2: Imagination --}}
                <div class="col-md-6 col-lg-3">
                    <div class="value-card card border-0 shadow-sm p-4 rounded-4 hover-up transition-all text-center h-100 bg-white">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center icon-size-60 icon-transition-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Magical Imagination</h4>
                        <p class="text-secondary small mb-0">Integrating custom backlit motif animations and starry lighting setups that stimulate early childhood development.</p>
                    </div>
                </div>

                {{-- Value 3: Craftsmanship --}}
                <div class="col-md-6 col-lg-3">
                    <div class="value-card card border-0 shadow-sm p-4 rounded-4 hover-up transition-all text-center h-100 bg-white">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center icon-size-60 icon-transition-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Master Artisanry</h4>
                        <p class="text-secondary small mb-0">Every single furniture design is handcrafted by our elite carpenters, combining precision with absolute nursery luxury.</p>
                    </div>
                </div>

                {{-- Value 4: Sleep & Wellness --}}
                <div class="col-md-6 col-lg-3">
                    <div class="value-card card border-0 shadow-sm p-4 rounded-4 hover-up transition-all text-center h-100 bg-white">
                        <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center icon-size-60 icon-transition-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Sleep & Wellness</h4>
                        <p class="text-secondary small mb-0">Scientifically designed room layouts optimize ventilation, light, and soothing pastel hues for a deeper infant sleep.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Reusable Inquiry Section --}}
    @include('frontend.partials.inquiry')
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Scroll counter animation
    const counters = document.querySelectorAll('.counter');
    const speed = 100; // lower number = faster speed

    const startCounting = (counter) => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;

            // Calculate increment based on speed
            const increment = Math.ceil(target / speed);

            if (count < target) {
                counter.innerText = count + increment > target ? target : count + increment;
                setTimeout(updateCount, 15);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    };

    // Trigger on scroll using Intersection Observer
    const statsSection = document.getElementById('about-stats');
    if (statsSection) {
        let hasCounted = false;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasCounted) {
                    hasCounted = true;
                    counters.forEach(counter => startCounting(counter));
                    observer.unobserve(statsSection);
                }
            });
        }, {
            threshold: 0.15
        });

        observer.observe(statsSection);
    }
});
</script>
@endsection
