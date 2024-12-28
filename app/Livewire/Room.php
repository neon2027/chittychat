<?php

namespace App\Livewire;

use App\Events\MessageEvent;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Room extends Component
{
    public \App\Models\Room $room;

    public ?string $message = '';
    public $messages = [];

    public function getListeners()
    {
        return [
            "echo-private:room.{$this->room->id},MessageEvent" => 'messageSent'
        ];
    }

    public function messageSent($message)
    {
        $this->room->load('messages');
        $this->messages = $this->room->messages->groupBy(function($message) {
            return $message->created_at->format('Y-m-d H:00');
        })
        ->mapWithKeys(function($group, $key) {
            $firstMessage = $group->first();
            $newKey = $firstMessage->created_at->format('Y-m-d H:i');
            return [$newKey => $group];
        });
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
        $this->messages = $this->room->messages->groupBy(function($message) {
            return $message->created_at->format('Y-m-d H:00');
        })
        ->mapWithKeys(function($group, $key) {
            $firstMessage = $group->first();
            $newKey = $firstMessage->created_at->format('Y-m-d H:i');
            return [$newKey => $group];
        });
    }

    public function render()
    {
        return view('livewire.room');
    }

    public function sendMessage()
    {

        $message = $this->room->messages()->create([
            'user_id' => auth()->id(),
            'content' => nl2br($this->message),
        ]);


        $this->message = '';
        MessageEvent::dispatch($message);
        $this->dispatch('message-sent');
    }
}
