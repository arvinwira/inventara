<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventara') }}</title>

        <!-- Favicon & Meta -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('logo/inventara_favicon.svg') }}?v=1">
        <meta name="theme-color" content="#B71C1C">
        <meta property="og:image" content="{{ asset('logo/inventara_logo.svg') }}">
        <meta property="og:title" content="Inventara — Kelola Stok & Penjualan Mudah">
        <meta property="og:description" content="Aplikasi untuk UMKM: produk, stok, transaksi, dan laporan.">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen bg-gray-50">
            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                <!-- Top Header Bar -->
                <header class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10 shrink-0">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1"></div>

                    <!-- Profile Dropdown -->
                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div class="hidden md:block text-left">
                                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                                            <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                                        </div>
                                    </div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 md:hidden">
                                     <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                     <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="border-t border-gray-100 md:hidden"></div>
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <span class="text-red-600">{{ __('Log Out') }}</span>
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Page Scrollable Content -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Page Heading -->
                    @isset($header)
                        <div class="bg-white border-b border-gray-100">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    <!-- Main Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        @include('partials.toast')
    </body>
</html>
