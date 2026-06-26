@props([
    'title' => 'About Us',
    'bgImage' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1600',
    'breadcrumbs' => []
])

<section class="page-banner-section position-relative overflow-hidden py-5 d-flex align-items-center" style="background-image: linear-gradient(rgba(33, 33, 33, 0.6), rgba(33, 33, 33, 0.6)), url('{{ $bgImage }}');">
    {{-- Soft background decorations --}}
    <div class="banner-shape-decor position-absolute bottom-0 start-0 w-100 overflow-hidden">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="banner-svg-divider">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V120H1.2C48,103.88,114.73,81.42,176.4,72.93,240.23,64.12,284.18,63.35,321.39,56.44Z" fill="#f8f9fa"></path>
        </svg>
    </div>

    <div class="container position-relative z-3">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="badge bg-primary text-white mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-2">Lumos Nursery Design</span>
                <h1 class="display-3 fw-bold text-white mb-4 banner-title text-shadow-sm">{{ $title }}</h1>
                
                {{-- Breadcrumbs --}}
                @if(!empty($breadcrumbs))
                    <nav aria-label="breadcrumb" class="d-inline-flex bg-white bg-opacity-15 backdrop-blur-md rounded-pill px-4 py-2 border border-white border-opacity-20">
                        <ol class="breadcrumb mb-0">
                            @foreach($breadcrumbs as $index => $item)
                                @if($loop->last)
                                    <li class="breadcrumb-item active text-white fw-medium" aria-current="page">{{ $item['label'] }}</li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $item['url'] }}" class="text-white text-opacity-80 text-decoration-none hover-white transition-all">{{ $item['label'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</section>
