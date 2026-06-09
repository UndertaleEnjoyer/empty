<div class="space-y-6">
    @if (!$twoFactorEnabled)
        <div>
            <h3 class="text-lg font-medium">{{ __('Two Factor Authentication') }}</h3>
            <p class="text-muted small mt-2">{{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication.') }}</p>
            <button type="button" wire:click="enableTwoFactor" class="btn btn-primary mt-3">
                {{ __('Enable') }}
            </button>
        </div>
    @else
        <div>
            <h3 class="text-lg font-medium">{{ __('Two Factor Authentication is Enabled') }}</h3>
            <p class="text-muted small mt-2">{{ __('You have enabled two factor authentication.') }}</p>
            <button type="button" wire:click="disableTwoFactor" class="btn btn-danger mt-3">
                {{ __('Disable') }}
            </button>
        </div>

        @if ($confirmingTwoFactorDisable)
            <div class="alert alert-warning" role="alert">
                <p class="mb-3">{{ __('Please confirm your password to disable two factor authentication.') }}</p>
                <div>
                    <input type="password" wire:model="confirmPassword" class="form-control" placeholder="{{ __('Password') }}">
                    @error('confirmPassword') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3 d-flex gap-2">
                    <button type="button" wire:click="confirmDisableTwoFactor" class="btn btn-danger">
                        {{ __('Disable') }}
                    </button>
                    <button type="button" wire:click="$set('confirmingTwoFactorDisable', false)" class="btn btn-secondary">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        @endif
    @endif
</div>
