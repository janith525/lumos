<x-layouts::auth :title="__('Forgot password')">
    <div class="d-flex flex-column gap-2">
        <div class="text-center mb-4">
            <h3 class="auth-title">{{ __('Forgot password') }}</h3>
            <p class="auth-description text-muted">{{ __('Enter your email to receive a password reset link') }}</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success auth-alert mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger auth-alert mb-4" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column gap-3">
            @csrf

            <!-- Email Address -->
            <div class="text-start">
                <label for="email" class="form-label auth-form-label">{{ __('Email address') }}</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control auth-form-control @error('email') is-invalid @enderror" 
                    placeholder="email@example.com" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mt-2" data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="auth-footer-text">{{ __('Or, return to') }}</span>
            <a href="{{ route('login') }}" class="auth-link text-decoration-none" wire:navigate>{{ __('log in') }}</a>
        </div>
    </div>
</x-layouts::auth>
