<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Produk</h2>
  </x-slot>

  <div class="p-6 space-y-4">
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif

    <div class="flex items-center justify-between gap-2">
      <form method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama/SKU/kategori"
               class="border rounded px-3 py-2 w-64">
        <button class="bg-gray-800 text-white px-3 py-2 rounded">Cari</button>
        @if($q)
          <a href="{{ route('products.index') }}" class="px-3 py-2 border rounded">Reset</a>
        @endif
      </form>
      <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Produk</a>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-600 rounded shadow">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-600">
          <tr class="text-left">
            <th class="px-4 py-2">SKU</th>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Kategori</th>
            <th class="px-4 py-2 text-right">HPP</th>
            <th class="px-4 py-2 text-right">Harga Jual</th>
            <th class="px-4 py-2 text-right">Reorder</th>
            <th class="px-4 py-2 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $p)
            <tr class="border-t">
              <td class="px-4 py-2 font-mono">{{ $p->sku }}</td>
              <td class="px-4 py-2">{{ $p->name }}</td>
              <td class="px-4 py-2">{{ $p->category ?? '-' }}</td>
              <td class="px-4 py-2 text-right">Rp {{ number_format($p->cost_price,0,',','.') }}</td>
              <td class="px-4 py-2 text-right">Rp {{ number_format($p->sell_price,0,',','.') }}</td>
              <td class="px-4 py-2 text-right">{{ $p->reorder_point }}</td>
              <td class="px-4 py-2">
                <div class="flex justify-end gap-2">
                  <a href="{{ route('products.show',$p) }}" class="px-2 py-1 border rounded">Detail</a>
                  <a href="{{ route('products.edit',$p) }}" class="px-2 py-1 border rounded">Edit</a>
                  <form method="POST" action="{{ route('products.destroy',$p) }}" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td class="px-4 py-6 text-center" colspan="7">Belum ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div>
      {{ $products->links() }}
    </div>
  </div>
</x-app-layout>
