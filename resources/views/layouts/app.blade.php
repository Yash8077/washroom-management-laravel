<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF Token for AJAX requests --}}

        <title>{{ config('app.name', 'Washroom Management') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Add any page-specific head elements --}}
        @isset($head)
            {{ $head }}
        @endisset
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{-- Include Navigation (Breeze often puts this in a separate component/partial) --}}
            {{-- Check resources/views/layouts/navigation.blade.php if using Breeze --}}
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }} {{-- Slot for page-specific headers --}}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }} {{-- This is where the content of specific views will be injected --}}
            </main>

            {{-- Optional Footer --}}
            {{-- <footer class="bg-white dark:bg-gray-800 mt-auto py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                © {{ date('Y') }} Washroom Management System
            </footer> --}}
        </div>

         {{-- Add any page-specific scripts --}}
         @isset($scripts)
            {{ $scripts }}
        @endisset
    </body>
</html>