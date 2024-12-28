<?php

namespace App\Livewire;

use App\Events\MessageEvent;
use Livewire\Component;

class Room extends Component
{
    public \App\Models\Room $room;
    public ?string $message = '';

    public function getListeners()
    {
        return [
            "echo-private:room.{$this->room->id},MessageEvent" => 'messageSent'
        ];
    }

    public function messageSent($message)
    {
        $this->room->load('messages');
    }

    public function leaveRoom()
    {
        $this->room->users()->detach(auth()->id());
        $this->room->messages()->create([
            'user_id' => auth()->id(),
            'content' => auth()->user()->name. ' left the room',
            'type' => 'leave'
        ]);
        return redirect()->route('chat');
    }

    public function mount($id)
    {
        $this->room = \App\Models\Room::find($id);
    }

    public function render()
    {
        return view('livewire.room');
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required'
        ]);

        $message = $this->room->messages()->create([
            'user_id' => auth()->id(),
            'content' => $this->message
        ]);


        $this->message = '';
        MessageEvent::dispatch($message);
        $this->dispatch('message-sent');
    }
}
