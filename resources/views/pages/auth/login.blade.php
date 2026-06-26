<x-layouts::auth :title="__('Log in')">
    <div class="d-flex flex-column gap-2">
        <div class="text-center mb-4">
            <h3 class="auth-title">{{ __('Log in to your account') }}</h3>
            <p class="auth-description text-muted">{{ __('Enter your email and password below to log in') }}</p>
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

        <form method="POST" action="{{ route('login.store') }}" class="d-flex flex-column gap-3">
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
                    autocomplete="email"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="text-start">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label auth-form-label mb-0">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link text-decoration-none" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                <div class="auth-input-group">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control auth-form-control @error('password') is-invalid @enderror" 
                        placeholder="{{ __('Password') }}" 
                        required 
                        autocomplete="current-password"
                    >
                    <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="{{ __('Toggle password visibility') }}">{{ __('Show') }}</button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Remember Me -->
            <div class="text-start my-2">
                <label class="d-inline-flex align-items-center auth-checkbox">
                    <input type="checkbox" name="remember" class="form-check-input me-2" {{ old('remember') ? 'checked' : '' }}>
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Log In Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mt-2" data-test="login-button">
                {{ __('Log in') }}
            </button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, btn) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                btn.textContent = "{{ __('Hide') }}";
            } else {
                field.type = 'password';
                btn.textContent = "{{ __('Show') }}";
            }
        }
    </script>
</x-layouts::auth>
