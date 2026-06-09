<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Actions\Jetstream\DeleteUser;

class DeleteUserForm extends Component
{
    public $confirmingUserDeletion = false;
    public $password = '';

    public function confirmUserDeletion()
    {
        $this->confirmingUserDeletion = true;
    }

    public function deleteUser()
    {
        $this->validate([
            'password' => 'required|current_password',
        ]);

        (new DeleteUser())->delete(auth()->user());

        auth()->logout();

        redirect('/');
    }

    public function render()
    {
        return view('livewire.profile.delete-user-form');
    }
}
