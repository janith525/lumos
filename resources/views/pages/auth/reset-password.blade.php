<x-layouts::auth :title="__('Reset password')">
    <div class="d-flex flex-column gap-2">
        <div class="text-center mb-4">
            <h3 class="auth-title">{{ __('Reset password') }}</h3>
            <p class="auth-description text-muted">{{ __('Please enter your new password below') }}</p>
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

        <form method="POST" action="{{ route('password.update') }}" class="d-flex flex-column gap-3">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <div class="text-start">
                <label for="email" class="form-label auth-form-label">{{ __('Email address') }}</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control auth-form-control @error('email') is-invalid @enderror" 
                    placeholder="email@example.com" 
                    value="{{ old('email', request('email')) }}" 
                    required 
                    autocomplete="email"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="text-start">
                <label for="password" class="form-label auth-form-label">{{ __('Password') }}</label>
                <div class="auth-input-group">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control auth-form-control @error('password') is-invalid @enderror" 
                        placeholder="{{ __('Password') }}" 
                        required 
                        autocomplete="new-password"
                    >
                    <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="{{ __('Toggle password visibility') }}">{{ __('Show') }}</button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="text-start">
                <label for="password_confirmation" class="form-label auth-form-label">{{ __('Confirm password') }}</label>
                <div class="auth-input-group">
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="form-control auth-form-control @error('password_confirmation') is-invalid @enderror" 
                        placeholder="{{ __('Confirm password') }}" 
                        required 
                        autocomplete="new-password"
                    >
                    <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)" aria-label="{{ __('Toggle password visibility') }}">{{ __('Show') }}</button>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mt-2" data-test="reset-password-button">
                {{ __('Reset password') }}
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
