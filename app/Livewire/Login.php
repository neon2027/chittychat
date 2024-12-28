<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|email')]
    public $email;

    #[Validate('required|min:6')]
    public $password;

    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate();

        if(auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->to('/dashboard');
        }
    }


}
