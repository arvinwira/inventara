<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventara') }}</title>

        <!-- Favicon & Meta -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('logo/inventara_log.svg') }}?v=2">
        <meta name="theme-color" content="#B71C1C">
        <meta property="og:image" content="{{ asset('logo/inventara_log.svg') }}">
        <meta property="og:title" content="Inventara — Kelola Stok & Penjualan Mudah">
        <meta property="og:description" content="Aplikasi untuk UMKM: produk, stok, transaksi, dan laporan.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
