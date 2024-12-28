<div>
    <div class="max-w-md bg-white p-6 rounded-lg shadow-sm">
        <div class="space-y-2">
            <h1>Create a room</h1>
            <p class="text-gray-500">Create a room to start chatting with your friends and family.</p>
        </div>
        <div class="space-y-4 mt-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model="roomForm.roomName" id="name" name="name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('roomForm.roomName')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="roomForm.description" id="description" name="description"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                @error('roomForm.description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="roomForm.isPrivate" id="isPrivate" name="isPrivate"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="isPrivate" class="ml-2 block text-sm font-medium text-gray-700">Private Room</label>
                </div>
                @if ($roomForm->isPrivate)
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Room Password</label>
                        <input type="password" wire:model="roomForm.password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('roomForm.password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>
            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number" wire:model="roomForm.capacity" id="capacity" name="capacity"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('roomForm.capacity')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button wire:click="createRoom"
                class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600">Create
                Room</button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        @forelse ($rooms as $room)
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex justify-between gap-4">
                    <h2 class="font-bold text-lg">{{ $room->room_name }}</h2>
                    @if ($room->isPrivate())
                        <span class="text-sm text-gray-500">Private</span>
                    @endif
                </div>
                <p class="text-gray-500">{{ $room->description }}</p>
                <div class="mt-4">
                    <span class="text-gray-700">Members: {{ $room->users->count() }}/{{ $room->capacity }}</span>
                </div>
                @if (!auth()->user()->isInRoom($room->id))
                    <div class="mt-4">
                        <button wire:click='joinRoom({{ $room->id }})'
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600">Join
                            Room</button>
                    </div>
                @else
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button wire:click='leaveRoom({{ $room->id }})'
                            class="border border-red-500 text-red-500 hover:text-white font-bold py-2 px-4 rounded-md hover:bg-red-600">Leave
                            Room</button>
                        <a href="{{ route('room', $room->id) }}"
                            class="text-center bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600">Enter
                            Room</a>
                    </div>
                @endif
            </div>
        @empty
            <span>No Rooms available</span>
        @endforelse
    </div>
</div>

@script
    <script>
        $wire.on('private-room', () => {
            alert('This is a private room');
        });
    </script>
@endscript
