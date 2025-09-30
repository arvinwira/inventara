<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">Tambah Produk</h2></x-slot>
  <div class="p-6">
    <form method="POST" action="{{ route('products.store') }}" class="bg-white dark:bg-gray-600 p-6 rounded shadow space-y-4">
      @include('products._form', ['submit' => 'Tambah'])
    </form>
  </div>
</x-app-layout>
