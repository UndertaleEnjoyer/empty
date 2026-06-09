<div class="space-y-6">
    <div>
        <h3 class="text-lg font-medium text-danger">{{ __('Delete Account') }}</h3>
        <p class="text-muted small mt-2">{{ __('Once your account is deleted, there is no going back. Please be certain.') }}</p>
    </div>

    <button type="button" wire:click="confirmUserDeletion" class="btn btn-danger">
        {{ __('Delete Account') }}
    </button>

    @if ($confirmingUserDeletion)
        <div class="alert alert-danger" role="alert">
            <p class="mb-3">{{ __('Are you sure you want to delete your account? This action cannot be undone.') }}</p>
            <div>
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input type="password" id="password" wire:model="password" class="form-control" placeholder="{{ __('Password') }}" required>
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="mt-3 d-flex gap-2">
                <button type="button" wire:click="deleteUser" class="btn btn-danger">
                    {{ __('Delete Account') }}
                </button>
                <button type="button" wire:click="$set('confirmingUserDeletion', false)" class="btn btn-secondary">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    @endif
</div>
