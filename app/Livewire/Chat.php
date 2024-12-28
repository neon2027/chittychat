<?php

namespace App\Livewire;

use App\Livewire\Forms\RegisterForm;
use App\Livewire\Forms\RoomForm;
use App\Models\Room;
use Livewire\Component;

class Chat extends Component
{

    public RoomForm $roomForm;
    public function render()
    {
        return view('livewire.chat', [
            'rooms' => Room::latest()->get()
        ]);
    }

    public function createRoom()
    {
        $this->roomForm->createRoom();
    }

    public function joinRoom($roomId)
    {
        if(Room::find($roomId)->isPrivate()) {
            $this->dispatch('private-room', $roomId);
        }
        $this->roomForm->joinRoom($roomId);
    }

    public function leaveRoom($roomId)
    {
        $this->roomForm->leaveRoom($roomId);
    }
}
