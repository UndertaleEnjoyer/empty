<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Actions\Fortify\UpdateUserProfileInformation;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    public $state = [];
    public $photo;
    public $verificationLinkSent = false;

    public function mount()
    {
        $this->state = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        (new UpdateUserProfileInformation())->update(
            auth()->user(),
            $this->state,
        );

        $this->dispatch('saved');
    }

    public function deleteProfilePhoto()
    {
        auth()->user()->deleteProfilePhoto();
    }

    public function sendEmailVerification()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            redirect('/dashboard');
        }

        auth()->user()->sendEmailVerificationNotification();
        $this->verificationLinkSent = true;
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }
}
