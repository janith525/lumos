<x-layouts::auth :title="__('Confirm password')">
    <div class="d-flex flex-column gap-2">
        <div class="text-center mb-4">
            <h3 class="auth-title">{{ __('Confirm password') }}</h3>
            <p class="auth-description text-muted">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
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

        <form method="POST" action="{{ route('password.confirm.store') }}" class="d-flex flex-column gap-3">
            @csrf

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
                        autocomplete="current-password"
                        autofocus
                    >
                    <button type="button" class="btn-toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="{{ __('Toggle password visibility') }}">{{ __('Show') }}</button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mt-2" data-test="confirm-password-button">
                {{ __('Confirm') }}
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
