@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">SKU</label>
    <input name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border rounded px-3 py-2">
    @error('sku') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Nama</label>
    <input name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border rounded px-3 py-2">
    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Kategori</label>
    <input name="category" value="{{ old('category', $product->category ?? '') }}" class="w-full border rounded px-3 py-2">
    @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Satuan</label>
    <input name="unit" value="{{ old('unit', $product->unit ?? 'pcs') }}" class="w-full border rounded px-3 py-2">
    @error('unit') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Harga Pokok (HPP)</label>
    <input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price', $product->cost_price ?? 0) }}" class="w-full border rounded px-3 py-2">
    @error('cost_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Harga Jual</label>
    <input type="number" step="0.01" min="0" name="sell_price" value="{{ old('sell_price', $product->sell_price ?? 0) }}" class="w-full border rounded px-3 py-2">
    @error('sell_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Reorder Point</label>
    <input type="number" min="0" name="reorder_point" value="{{ old('reorder_point', $product->reorder_point ?? 0) }}" class="w-full border rounded px-3 py-2">
    @error('reorder_point') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
</div>

<div class="mt-6 flex items-center gap-2">
  <button class="bg-blue-600 text-white px-4 py-2 rounded">
    {{ $submit ?? 'Simpan' }}
  </button>
  <a href="{{ route('products.index') }}" class="px-4 py-2 border rounded">Batal</a>
</div>
