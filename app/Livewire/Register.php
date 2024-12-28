<?php

namespace App\Livewire;

use App\Livewire\Forms\RegisterForm;
use Livewire\Component;

class Register extends Component
{
    public RegisterForm $form;

    public function render()
    {
        return view('livewire.register');
    }

    public function submit()
    {
        $this->form->register();
    }
}
