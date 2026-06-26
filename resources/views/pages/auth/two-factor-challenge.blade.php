<x-layouts::auth :title="__('Two-factor authentication')">
    <div class="d-flex flex-column gap-2"
         x-cloak
         x-data="{
             showRecoveryInput: @js($errors->has('recovery_code')),
             code: '',
             recovery_code: '',
             toggleInput() {
                 this.showRecoveryInput = !this.showRecoveryInput;
                 this.code = '';
                 this.recovery_code = '';
                 if (this.showRecoveryInput) {
                     this.$nextTick(() => { this.$refs.recovery_code.focus(); });
                 } else {
                     this.$nextTick(() => { this.$refs.code.focus(); });
                 }
             }
         }"
    >
        <!-- Title and description based on current input mode -->
        <div class="text-center mb-4">
            <h3 class="auth-title" x-show="!showRecoveryInput">{{ __('Two-factor Confirmation') }}</h3>
            <h3 class="auth-title" x-show="showRecoveryInput">{{ __('Recovery Code') }}</h3>
            
            <p class="auth-description text-muted" x-show="!showRecoveryInput">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </p>
            <p class="auth-description text-muted" x-show="showRecoveryInput">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </p>
        </div>

        <!-- Session Status / Errors -->
        @if ($errors->any())
            <div class="alert alert-danger auth-alert mb-4" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="d-flex flex-column gap-3">
            @csrf

            <!-- Auth Code Input (Normal) -->
            <div class="text-start" x-show="!showRecoveryInput">
                <label for="code" class="form-label auth-form-label">{{ __('Authentication Code') }}</label>
                <input 
                    type="text" 
                    name="code" 
                    id="code" 
                    x-ref="code"
                    class="form-control auth-form-control @error('code') is-invalid @enderror" 
                    placeholder="000000" 
                    x-model="code"
                    x-bind:required="!showRecoveryInput"
                    autocomplete="one-time-code"
                    autofocus
                >
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Recovery Code Input -->
            <div class="text-start" x-show="showRecoveryInput">
                <label for="recovery_code" class="form-label auth-form-label">{{ __('Recovery Code') }}</label>
                <input 
                    type="text" 
                    name="recovery_code" 
                    id="recovery_code" 
                    x-ref="recovery_code"
                    class="form-control auth-form-control @error('recovery_code') is-invalid @enderror" 
                    placeholder="xxxx-xxxx-xxxx" 
                    x-model="recovery_code"
                    x-bind:required="showRecoveryInput"
                    autocomplete="one-time-code"
                >
                @error('recovery_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth-submit w-100 mt-2">
                {{ __('Confirm') }}
            </button>
        </form>

        <div class="text-center mt-4">
            <button type="button" class="btn btn-link auth-link text-decoration-none" @click="toggleInput()">
                <span x-show="!showRecoveryInput">{{ __('Use a recovery code') }}</span>
                <span x-show="showRecoveryInput">{{ __('Use an authentication code') }}</span>
            </button>
        </div>
    </div>
</x-layouts::auth>
