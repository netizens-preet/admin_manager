<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Storefront</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass {
            background: rgba(22, 22, 21, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="sticky top-0 z-50 glass border-b border-[#19140015] dark:border-[#ffffff10]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-8">
                        <a href="/" class="flex items-center gap-2 group">
                            <x-application-logo class="w-8 h-8 fill-current text-[#f53003]" />
                            <span class="font-bold text-xl tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </div>

                    <nav class="flex items-center gap-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-sm font-medium hover:text-[#f53003] transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm font-medium hover:text-[#f53003] transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center px-4 py-2 border border-[#1b1b18] dark:border-[#EDEDEC] rounded-full text-sm font-medium hover:bg-[#1b1b18] hover:text-white dark:hover:bg-[#EDEDEC] dark:hover:text-[#0a0a0a] transition-all">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="border-t border-[#19140015] dark:border-[#ffffff10] py-12 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-center gap-8 text-[#706f6c] dark:text-[#A1A09A] text-sm">
                    <div class="flex items-center gap-4">
                        <x-application-logo class="w-6 h-6 grayscale opacity-50" />
                        <span>&copy; {{ date('Year') }} {{ config('app.name') }}. All rights reserved.</span>
                    </div>
                    <div class="flex gap-8">
                        <a href="#"
                            class="hover:text-[#1b1b18] dark:hover:text-white transition-colors">Documentation</a>
                        <a href="#" class="hover:text-[#1b1b18] dark:hover:text-white transition-colors">Laracasts</a>
                        <a href="#" class="hover:text-[#1b1b18] dark:hover:text-white transition-colors">Vapor</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>