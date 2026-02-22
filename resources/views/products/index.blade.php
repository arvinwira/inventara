<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Produk</h2>
  </x-slot>

  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6 fade-in-up">
    @if(session('success'))
      <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <!-- Card Header -->
      <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" class="flex flex-1 max-w-md gap-2">
          <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama/SKU/kategori..."
                   class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-brand-500 focus:border-brand-500 block w-full pl-10 p-2.5 transition-colors">
          </div>
          <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-800 rounded-lg border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300">
             Cari
          </button>
          @if($q)
            <a href="{{ route('products.index') }}" class="p-2.5 ms-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-brand-700 transition-colors">Reset</a>
          @endif
        </form>
        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Tambah Produk
        </a>
      </div>

      <!-- Table Section -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
            <tr>
              <th scope="col" class="px-6 py-4 font-medium">SKU</th>
              <th scope="col" class="px-6 py-4 font-medium">Nama Produk</th>
              <th scope="col" class="px-6 py-4 font-medium">Kategori</th>
              <th scope="col" class="px-6 py-4 font-medium text-right">Modal (HPP)</th>
              <th scope="col" class="px-6 py-4 font-medium text-right">Harga Jual</th>
              <th scope="col" class="px-6 py-4 font-medium text-right">Stok Min.</th>
              <th scope="col" class="px-6 py-4 font-medium text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($products as $p)
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $p->sku }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $p->name }}</td>
                <td class="px-6 py-4">
                  <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-gray-200">
                    {{ $p->category ?? '-' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right text-gray-500">Rp {{ number_format($p->cost_price,0,',','.') }}</td>
                <td class="px-6 py-4 text-right font-medium text-gray-900">Rp {{ number_format($p->sell_price,0,',','.') }}</td>
                <td class="px-6 py-4 text-right">
                  <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-gray-600 bg-gray-100 rounded-full">
                    {{ $p->reorder_point }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('products.show',$p) }}" class="text-xs px-3 py-1.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Detail</a>
                    <a href="{{ route('products.edit',$p) }}" class="text-xs px-3 py-1.5 font-medium text-brand-600 bg-brand-50 border border-brand-200 rounded-lg hover:bg-brand-100 transition-colors">Edit</a>
                    <form method="POST" action="{{ route('products.destroy',$p) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" class="inline-block">
                      @csrf @method('DELETE')
                      <button type="submit" class="text-xs px-3 py-1.5 font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-gray-500 text-sm">Belum ada data produk ditemukan.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div>
      {{ $products->links() }}
    </div>
  </div>
</x-app-layout>
