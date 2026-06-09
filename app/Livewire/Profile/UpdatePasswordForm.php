<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Actions\Fortify\UpdateUserPassword;

class UpdatePasswordForm extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function updatePassword()
    {
        $this->validate([
            'state.current_password' => 'required|string|current_password',
            'state.password' => 'required|string|min:8|confirmed|different:state.current_password',
        ]);

        (new UpdateUserPassword())->update(auth()->user(), $this->state);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.profile.update-password-form');
    }
}
