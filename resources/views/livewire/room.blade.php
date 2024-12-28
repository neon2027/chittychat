<div>
    <div class="px-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Room: {{ $room->room_name }}</h1>
            <p class="text-gray-500">{{ $room->description ?? 'No description' }}</p>
        </div>
        <div>
            <button wire:click="leaveRoom" class="bg-red-500 text-white px-4 py-2 rounded-md">
                Leave Room
            </button>
        </div>
    </div>
    <div class="mt-6  bg-white rounded-lg shadow-sm  relative  ">
        <div class="p-6 space-y-4 h-[calc(100vh-300px)] overflow-auto pb-16" id="messages">
            @forelse ($room->messages as $message)
                @if (in_array($message->type, ['join', 'leave']))
                    <div class="text-center text-gray-500">
                        <span class="text-xs">{{ $message->content }}</span>
                    </div>
                    @continue
                @endif
                <div @class([
                    'flex gap-4',
                    'justify-end' => $message->user_id === auth()->id(),
                    'justify-start' => $message->user_id !== auth()->id(),
                ])>
                    <div class="flex gap-2">
                        @if ($message->user_id !== auth()->id())
                            <img src="{{ 'https://ui-avatars.com/api/?name=' . $message->user->name . '&background=random&rounded=true' }}"
                                alt="{{ $message->user->name }}" class="w-8 h-8 rounded-full">
                        @endif
                        <div>
                            @if ($message->user_id !== auth()->id())
                                <span class="font-medium text-xs">{{ $message->user->name }}</span>
                            @endif
                            <div @class([
                                'flex items-center  gap-4 group',
                                'justify-end' => $message->user_id === auth()->id(),
                                'justify-start' => $message->user_id !== auth()->id(),
                            ])>
                                @if ($message->user_id === auth()->id())
                                    <div class="group-hover:block hidden">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                                <div @class([
                                    'px-2 py-1  rounded-lg',
                                    'bg-blue-500  text-white' => $message->user_id === auth()->id(),
                                    'bg-gray-200 text-gray-700' => $message->user_id !== auth()->id(),
                                ])>
                                    <div class="text-sm max-w-md">
                                        <p>{{ $message->content }}</p>
                                    </div>
                                </div>
                                @if ($message->user_id !== auth()->id())
                                    <div class="group-hover:block hidden">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div @class([
                                'text-start' => $message->user_id !== auth()->id(),
                                'text-end' => $message->user_id === auth()->id(),
                            ])>
                                <span class="text-xs text-gray-500">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        @if ($message->user_id === auth()->id())
                            <img src="{{ 'https://ui-avatars.com/api/?name=' . $message->user->name . '&background=random&rounded=true' }}"
                                alt="{{ $message->user->name }}" class="w-8 h-8 rounded-full">
                        @endif

                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No messages yet</div>
            @endforelse
        </div>
        <div class=" w-full end-0 bottom-0 bg-gradient-to-t from-white to-transparent ">
            <div class="p-6">
                <div class="text-end">
                    <span id="message-timer" class="text-gray-500 text-xs "></span>
                </div>
                <input type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Type your message..." wire:model="message" wire:keydown.enter="sendMessage">

            </div>
        </div>
    </div>

</div>

@script
    <script>
        const messages = document.getElementById('messages');
        messages.scrollTop = messages.scrollHeight;
        $wire.on('message-sent', () => {

            // Scroll to the bottom of the messages
            messages.scrollTop = messages.scrollHeight;
            playSound();
        });
        Echo.private("room.{{ $room->id }}")
            .listen('MessageEvent', (e) => {
                messages.scrollTop = messages.scrollHeight;
                playSound();
            });

        function playSound() {
            const audio = new Audio('{{ asset('assets/sounds/message-pop.mp3') }}');
            audio.play();
        }
    </script>
@endscript
