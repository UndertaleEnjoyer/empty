<div class="space-y-6">
    <p class="text-muted small">{{ __('If necessary, you may log out of all of your other browser sessions across all of your devices.') }}</p>

    <form wire:submit.prevent="logoutOtherSessions">
        <div>
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input type="password" id="password" wire:model="password" class="form-control" required>
            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Log Out Other Browser Sessions') }}
            </button>
            @if (session('status') === 'other-browser-sessions-logged-out')
                <span class="text-success small ms-3">{{ __('Done.') }}</span>
            @endif
        </div>
    </form>
</div>
