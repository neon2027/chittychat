<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    @filamentScripts
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="bg-white p-4">
        <div class="flex justify-between max-w-7xl mx-auto">
            <div class="">
                <a href="{{ route('chat') }}">
                    <strong>ChittyChat</strong>
                </a>
            </div>
            <div class="space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-blue-500" wire:navigate>Login</a>
                    <a href="#" class="text-blue-500">Register</a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="text-blue-500">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @vite('resources/js/app.js')
</body>

</html>
