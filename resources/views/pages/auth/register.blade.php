<x-layouts::auth :title="__('Register')">
    <div class="d-flex flex-col gap-3 text-center">
        <div class="mb-4">
            <h3 class="auth-title">{{ __('Registration Disabled') }}</h3>
            <p class="auth-description text-muted">{{ __('Public registration is currently disabled by policy.') }}</p>
        </div>

        <div class="alert alert-danger auth-alert mb-4" role="alert">
            {{ __('Please contact an administrator to get access to the Lumos CMS.') }}
        </div>

        <div class="text-center mt-3">
            <span class="auth-footer-text">{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" class="auth-link text-decoration-none" wire:navigate>{{ __('Log in') }}</a>
        </div>
    </div>
</x-layouts::auth>
