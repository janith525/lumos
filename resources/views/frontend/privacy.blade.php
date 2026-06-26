@extends('frontend.app')

@section('page_css', '')
@section('classes_body', 'privacy-page')

@section('content')
    @include('frontend.partials.banner', [
        'title' => 'Privacy Policy',
        'bgImage' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Privacy Policy']
        ]
    ])

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2 class="fw-bold mb-3">Privacy Policy</h2>
                <p class="text-muted">This privacy policy explains how Lumos Nursery Interior Studio collects, uses, and protects your personal information when you use our website and services.</p>

                <h4 class="mt-4">Information We Collect</h4>
                <p class="text-secondary">We may collect contact information, inquiry details, and other information you provide when contacting us or submitting inquiries.</p>

                <h4 class="mt-4">How We Use Information</h4>
                <p class="text-secondary">We use your information to respond to inquiries, provide services, and improve our offerings. We never sell personal data to third parties.</p>

                <h4 class="mt-4">Contact</h4>
                <p class="text-secondary">If you have questions about this policy, contact us at <a href="mailto:hello@lumos.lk">hello@lumos.lk</a>.</p>
            </div>
        </div>
    </section>
@endsection
