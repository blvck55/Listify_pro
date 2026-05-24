<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SetPasswordForm extends Component
{
    public string $password = '';
    public string $password_confirmation = '';

    public function save(): void
    {
        $this->validate([
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        // The User model casts 'password' as 'hashed', so plain text is fine here
        Auth::user()->update(['password' => $this->password]);

        $this->password = '';
        $this->password_confirmation = '';

        $this->dispatch('passwordSet');
    }

    public function render()
    {
        return view('livewire.set-password-form');
    }
}
