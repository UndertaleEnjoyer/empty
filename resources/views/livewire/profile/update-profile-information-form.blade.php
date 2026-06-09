<form wire:submit.prevent="updateProfileInformation" class="space-y-6">
    <div>
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input type="text" id="name" wire:model="state.name" class="form-control" required>
        @error('state.name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="email" id="email" wire:model="state.email" class="form-control" required>
        @error('state.email') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">
            {{ __('Save') }}
        </button>
        @if (session('status') === 'profile-information-updated')
            <span class="text-success small">{{ __('Saved.') }}</span>
        @endif
    </div>
</form>
