<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @filamentScripts
    @vite(['resources\js\app.js', 'resources\css\app.css'])
</head>

<body class="bg-gray-100">
    <nav class="bg-white p-4">
        <div class="flex justify-between max-w-7xl mx-auto">
            <div class="">
                <strong cl>ChittyChat</strong>
            </div>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-blue-500" wire:navigate>Login</a>
                <a href="#" class="text-blue-500">Register</a>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</body>

</html>