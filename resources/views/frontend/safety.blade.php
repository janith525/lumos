@extends('frontend.app')

@section('page_css', '')
@section('classes_body', 'safety-page')

@section('content')
    @include('frontend.partials.banner', [
        'title' => 'Safety Guide',
        'bgImage' => 'https://images.unsplash.com/photo-1505842465776-3b1f3d0d6b33?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Safety Guide']
        ]
    ])

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2 class="fw-bold mb-3">Safety Guide</h2>
                <p class="text-muted">Our safety guide outlines best practices for nursery furniture selection, installation, and ongoing maintenance to ensure child safety.</p>

                <h4 class="mt-4">Materials & Finishes</h4>
                <p class="text-secondary">We use non-toxic, water-based finishes and rounded-edge joinery. Avoid small detachable parts for young children.</p>

                <h4 class="mt-4">Installation Tips</h4>
                <p class="text-secondary">Secure furniture to walls when appropriate, follow manufacturer instructions, and keep small objects out of reach.</p>
            </div>
        </div>
    </section>
@endsection
