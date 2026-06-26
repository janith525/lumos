@extends('frontend.app')

@section('page_title', $title ?? 'Auth')
@section('page_css', 'resources/scss/frontend/pages/auth.scss')

@section('content')
<div class="auth-section py-5">
    <div class="container py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 auth-card overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
