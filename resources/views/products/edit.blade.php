<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">Edit Produk</h2></x-slot>
  <div class="p-6">
    <form method="POST" action="{{ route('products.update', $product) }}" class="bg-white dark:bg-gray-600 p-6 rounded shadow space-y-4">
      @method('PUT')
      @include('products._form', ['submit' => 'Update', 'product' => $product])
    </form>
  </div>
</x-app-layout>
