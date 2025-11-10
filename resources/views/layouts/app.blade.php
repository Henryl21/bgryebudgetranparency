<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Barangay eBudget Transparency') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Header -->
        @hasSection('header')
            <header class="bg-white shadow-md border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-800 font-semibold text-lg">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow py-8 px-6">
            @yield('content')
        </main>
    </div>

    <!-- Small fade-in effect -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.body.classList.add("opacity-100", "transition-opacity", "duration-500");
        });
    </script>
</body>
</html>
