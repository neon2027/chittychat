<?php

use App\Livewire\Chat;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Room;
use Illuminate\Support\Facades\Route;


Route::get('/',  fn() => to_route('login'))->name('welcome');

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});


Route::group(['middleware' => 'auth'], function() {
    Route::get('room/{id}', Room::class)->name('room');
    Route::get('chat', Chat::class)->name('chat');
});


