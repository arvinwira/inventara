<div class="flex">
    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen" 
         class="fixed inset-0 z-20 bg-gray-900/50 transition-opacity md:hidden"
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>

    <!-- Sidebar component -->
    <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
         class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-100 transition duration-300 transform md:relative md:translate-x-0 flex flex-col h-full">
         
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-100 shrink-0">
            <a href="{{ url('/') }}" class="flex items-center">
                 <img src="{{ asset('logo/inventara_logo.svg') }}" alt="Inventara" class="h-8 w-auto">
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2 hidden md:block">Utama</p>
            
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="{{ request()->routeIs('dashboard') ? 'text-brand-700' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md" onclick="alert('Fitur POS Kasir akan segera hadir')">
                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Kasir / POS
            </a>

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6 hidden md:block">Inventaris</p>

            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="{{ request()->routeIs('products.*') ? 'text-brand-700' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Produk
            </a>

            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md" onclick="alert('Fitur Log Pergerakan Stok akan segera hadir')">
                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Pergerakan Stok
            </a>

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6 hidden md:block">Manajemen</p>

            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md" onclick="alert('Fitur Laporan Penjualan akan segera hadir')">
                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan
            </a>

            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="{{ request()->routeIs('profile.*') ? 'text-brand-700' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>
        </nav>
        
        <!-- Bottom section -->
        <div class="p-4 border-t border-gray-100 flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:bg-red-50 transition-colors">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </div>
</div>
