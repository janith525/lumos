<x-layouts::auth :title="__('Email verification')">
    <div class="d-flex flex-column gap-2 text-center">
        <div class="mb-4">
            <h3 class="auth-title">{{ __('Verify your email') }}</h3>
            <p class="auth-description text-muted">
                {{ __('Please verify your email address by clicking on the link we just emailed to you. If you didn\'t receive it, we will gladly send you another.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success auth-alert mb-4" role="alert">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="d-flex flex-column gap-2 mt-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-auth-submit w-100">
                    {{ __('Resend verification email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-link auth-link text-decoration-none" data-test="logout-button">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</x-layouts::auth>
