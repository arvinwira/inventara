<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">Detail Produk</h2></x-slot>
  <div class="p-6 space-y-2">
    <div class="bg-white dark:bg-gray-600 p-6 rounded shadow">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><strong>SKU:</strong> {{ $product->sku }}</div>
        <div><strong>Nama:</strong> {{ $product->name }}</div>
        <div><strong>Kategori:</strong> {{ $product->category ?? '-' }}</div>
        <div><strong>Satuan:</strong> {{ $product->unit }}</div>
        <div><strong>HPP:</strong> Rp {{ number_format($product->cost_price,0,',','.') }}</div>
        <div><strong>Harga Jual:</strong> Rp {{ number_format($product->sell_price,0,',','.') }}</div>
        <div><strong>Reorder Point:</strong> {{ $product->reorder_point }}</div>
      </div>
      <div class="mt-6">
        <a href="{{ route('products.edit', $product) }}" class="px-3 py-2 border rounded">Edit</a>
        <a href="{{ route('products.index') }}" class="px-3 py-2 border rounded">Kembali</a>
      </div>
    </div>
  </div>
</x-app-layout>
