<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('required|email')]
    public $email;

    #[Validate('required|min:6')]
    public $password;

    #[Validate('required|min:6|same:password')]
    public $password_confirmation;

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        auth()->login($user);

        return to_route('welcome');
    }

    public function render()
    {
        return view('livewire.forms.register-form');
    }
}
