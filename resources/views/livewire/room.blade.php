@use(\Carbon\Carbon)
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
            @forelse ($messages as $time => $timeMessage)
                <div class="text-center font-bold text-xs text-gray-500">
                    {{ Carbon::parse($time)->format('h:i A') }}
                </div>
                @foreach ($timeMessage as $m)
                    @if (in_array($m->type, ['join', 'leave']))
                        <div class="text-center text-gray-500">
                            <span class="text-xs">{{ $m->content }}</span>
                        </div>
                        @continue
                    @endif
                    <div @class([
                        'flex gap-4',
                        'justify-end' => $m->user_id === auth()->id(),
                        'justify-start' => $m->user_id !== auth()->id(),
                    ])>
                        <div class="flex gap-2">
                            @if ($m->user_id !== auth()->id())
                                <img src="{{ 'https://ui-avatars.com/api/?name=' . $m->user->name . '&background=random&rounded=true' }}"
                                    alt="{{ $m->user->name }}" class="w-8 h-8 rounded-full">
                            @endif
                            <div x-data="{ showTimestamp: false }">
                                @if ($m->user_id !== auth()->id())
                                    <span class="font-medium text-xs">{{ $m->user->name }}</span>
                                @endif
                                <div @class([
                                    'flex items-center  gap-4 group',
                                    'justify-end' => $m->user_id === auth()->id(),
                                    'justify-start' => $m->user_id !== auth()->id(),
                                ])>
                                    <div @class([
                                        'px-2 py-1  rounded-lg',
                                        'bg-blue-500  text-white' => $m->user_id === auth()->id(),
                                        'bg-gray-200 text-gray-700' => $m->user_id !== auth()->id(),
                                    ]) @mouseenter="showTimestamp = true"
                                        @mouseleave="showTimestamp = false">
                                        <div class="text-sm max-w-md">
                                            <p>{{ $m->content }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div @class([
                                    'text-start' => $m->user_id !== auth()->id(),
                                    'text-end' => $m->user_id === auth()->id(),
                                ])>
                                    <span class="text-xs text-gray-500" x-show="showTimestamp" x-transition>
                                        Delivered {{ $m->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            @if ($m->user_id === auth()->id())
                                <img src="{{ 'https://ui-avatars.com/api/?name=' . $m->user->name . '&background=random&rounded=true' }}"
                                    alt="{{ $m->user->name }}" class="w-8 h-8 rounded-full">
                            @endif

                        </div>
                    </div>
                @endforeach
            @empty
                <div class="text-center text-gray-500 text-xs">No messages yet</div>
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
