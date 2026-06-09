<form wire:submit.prevent="updatePassword" class="space-y-6">
    <div>
        <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
        <input type="password" id="current_password" wire:model="state.current_password" class="form-control" required>
        @error('state.current_password') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password" class="form-label">{{ __('New Password') }}</label>
        <input type="password" id="password" wire:model="state.password" class="form-control" required>
        @error('state.password') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
        <input type="password" id="password_confirmation" wire:model="state.password_confirmation" class="form-control" required>
        @error('state.password_confirmation') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">
            {{ __('Update Password') }}
        </button>
        @if (session('status') === 'password-updated')
            <span class="text-success small">{{ __('Saved.') }}</span>
        @endif
    </div>
</form>
