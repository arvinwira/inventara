<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $products = Product::when($q, function($query) use ($q) {
                $query->where('name','like',"%$q%")
                      ->orWhere('sku','like',"%$q%")
                      ->orWhere('category','like',"%$q%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products','q'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success','Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success','Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Produk berhasil dihapus.');
    }
}
