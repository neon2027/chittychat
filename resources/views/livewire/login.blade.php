<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg">
        <div class="space-y-2">
            <h1 class="font-bold">Login to ChittyChat</h1>
            <p class="text-gray-500">{{ __('Enjoy chatting with your friends and family. Login to start chatting.') }}
            </p>
        </div>
        <div class="space-y-4 mt-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" id="email" name="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" wire:model="password" id="password" name="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button wire:click="login"
                class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600">Login</button>
            <p>
                <a href="{{ route('register') }}" class="text-blue-500" wire:navigate>Don't have an account?
                    Register</a>
            </p>

        </div>
    </div>
    <div>
        <div class="bg-gray-100 p-6 rounded-lg">
            <h2 class="font-bold text-lg">Data Privacy Notice</h2>
            <p class="text-gray-700 mt-2">
                We value your privacy and are committed to protecting your personal data. By logging in, you agree to
                our
                <a href="#" class="text-blue-500">Privacy Policy</a> and
                <a href="#" class="text-blue-500">Terms of Service</a>.
            </p>
        </div>
    </div>
</div>
