<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class LogoutOtherBrowserSessionsForm extends Component
{
    public $password = '';
    public $sessions = [];

    public function mount()
    {
        $this->loadSessions();
    }

    public function loadSessions()
    {
        $this->sessions = auth()->user()->sessions()->get()->toArray();
    }

    public function logoutOtherSessions()
    {
        $this->validate([
            'password' => 'required|current_password',
        ]);

        $this->password = '';
        $this->loadSessions();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.profile.logout-other-browser-sessions-form');
    }
}
