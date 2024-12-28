<?php

use App\Livewire\Chat;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Room;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/',  fn() => to_route('chat'))->name('welcome');

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});


Route::group(['middleware' => 'auth'], function() {
    Route::post('logout', function(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
    Route::get('room/{id}', Room::class)->name('room');
    Route::get('chat', Chat::class)->name('chat');
});

Route::get('messages', function() {
    return Message::all()
        ->groupBy(function($message) {
            return $message->created_at->format('Y-m-d H:00');
        })
        ->mapWithKeys(function($group, $key) {
            $firstMessage = $group->first();
            $newKey = $firstMessage->created_at->format('Y-m-d H:i');
            return [$newKey => $group];
        });
});

