<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    public $twoFactorEnabled = false;
    public $showQrCode = false;
    public $showRecoveryCodes = false;
    public $confirmingTwoFactorDisable = false;
    public $confirmPassword = '';

    public function mount()
    {
        $this->twoFactorEnabled = auth()->user()->two_factor_secret !== null;
    }

    public function enableTwoFactor()
    {
        $this->showQrCode = true;
    }

    public function disableTwoFactor()
    {
        $this->confirmingTwoFactorDisable = true;
    }

    public function confirmDisableTwoFactor()
    {
        $this->validate([
            'confirmPassword' => 'required|current_password',
        ]);

        auth()->user()->disableTwoFactorAuthentication();
        $this->twoFactorEnabled = false;
        $this->showQrCode = false;
        $this->showRecoveryCodes = false;
        $this->confirmingTwoFactorDisable = false;
        $this->confirmPassword = '';

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.profile.two-factor-authentication-form');
    }
}
