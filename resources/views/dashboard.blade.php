<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Dashboard Inventara</h2>
  </x-slot>

  <div class="p-6 space-y-6">

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white dark:bg-gray-600 p-4 rounded shadow">
        <div class="text-sm text-gray-500">Total Produk</div>
        <div class="text-2xl font-semibold">{{ $productCount }}</div>
      </div>
      <div class="bg-white dark:bg-gray-600 p-4 rounded shadow">
        <div class="text-sm text-gray-500">Produk Low Stock</div>
        <div class="text-2xl font-semibold">{{ $lowStockCount }}</div>
      </div>
    </div>

    {{-- Tabel Low Stock --}}
    <div class="bg-white dark:bg-gray-600 p-4 rounded shadow">
      <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold">Produk Hampir Habis</h3>
        <a href="{{ route('products.index') }}" class="text-blue-600">Kelola Produk →</a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-600">
            <tr>
              <th class="px-3 py-2 text-left">SKU</th>
              <th class="px-3 py-2 text-left">Nama</th>
              <th class="px-3 py-2 text-right">Stok</th>
              <th class="px-3 py-2 text-right">Reorder Point</th>
            </tr>
          </thead>
          <tbody>
            @forelse($lowStocks as $p)
              <tr class="border-t">
                <td class="px-3 py-2 font-mono">{{ $p->sku }}</td>
                <td class="px-3 py-2">{{ $p->name }}</td>
                <td class="px-3 py-2 text-right">{{ $p->current_stock }}</td>
                <td class="px-3 py-2 text-right">{{ $p->reorder_point }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                  Tidak ada produk yang low stock.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</x-app-layout>
