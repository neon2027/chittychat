<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="space-y-2">
                <h1>Register your account</h1>
                <p class="text-gray-500">Create an account to start chatting with your friends and family.</p>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="form.name" id="name" name="name"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('form.name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="form.email" id="email" name="email"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('form.email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" wire:model="form.password" id="password" name="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('form.password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" wire:model="form.password_confirmation" id="password_confirmation"
                        name="password_confirmation"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('form.password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button wire:click="submit"
                    class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600">Register</button>
            </div>
        </div>
        <div>
            <h2 class="text-lg font-bold  text-gray-900">Your Data is Safe</h2>
            <ul class="list-disc list-inside text-gray-700 mt-4 space-y-2 ms-4">
                <li>We use advanced encryption to protect your personal information.</li>
                <li>Your data is stored securely on our servers.</li>
                <li>We do not share your information with third parties without your consent.</li>
                <li>You can delete your account and data at any time.</li>
                <li>Our team is committed to maintaining your privacy and security.</li>
            </ul>
        </div>
    </div>
</div>
