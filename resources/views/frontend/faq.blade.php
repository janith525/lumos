@extends('frontend.app')

@section('page_css', '')
@section('classes_body', 'faq-page')

@section('content')
    @include('frontend.partials.banner', [
        'title' => 'FAQ',
        'bgImage' => 'https://images.unsplash.com/photo-1582719478174-1f38e6b98a9d?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'FAQ']
        ]
    ])

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2 class="fw-bold mb-3">Frequently Asked Questions</h2>

                <div class="mb-4">
                    <h5 class="fw-semibold">Do you offer custom sizes?</h5>
                    <p class="text-secondary">Yes — we build bespoke furniture to your specifications. Contact us for a consultation.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-semibold">What materials do you use?</h5>
                    <p class="text-secondary">We use sustainably sourced solid timbers and non-toxic finishes suitable for children's spaces.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
