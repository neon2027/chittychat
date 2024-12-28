<?php

namespace App\Livewire\Forms;

use App\Models\Room;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RoomForm extends Form
{
    #[Validate('required')]
    public $roomName;
    public $roomDescription;
    public $isPrivate = false;
    #[Validate('required_if:isPrivate,true', message: 'Password is required for private rooms')]
    public $password;
    #[Validate('required|integer')]
    public $capacity;

    public function createRoom()
    {
        $this->validate();

        auth()->user()->rooms()->create([
            'room_name' => $this->roomName,
            'description' => $this->roomDescription,
            'password' => bcrypt($this->password),
            'is_private' => $this->isPrivate,
            'capacity' => $this->capacity,
        ]);
    }

    public function joinRoom($roomId)
    {
        $room = Room::find($roomId);
        if (!$room) {
            return back()->with('error', 'Room not found');
        }

        if($room->isPrivate()) {
            $this->validate([
                'password' => 'required'
            ]);

            if (!Hash::check($this->password, $room->password)) {
                return back()->with('error', 'Invalid password');
            }
        }

        $room->users()->attach(auth()->id());
        $room->messages()->create([
            'user_id' => auth()->id(),
            'content' => auth()->user()->name. ' joined the room',
            'type' => 'join'
        ]);
    }

    public function leaveRoom($roomId) {
        $room = Room::find($roomId);
        if (!$room) {
            return back()->with('error', 'Room not found');
        }

        $room->users()->detach(auth()->id());
    }
}
