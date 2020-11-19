<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
use App\Kategori;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::all();
        $kategoris = Kategori::all();
        return view('product.create', compact('stores', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'kategori_id' => 'required',
            'nm_barang' => 'required|min:2',
            // 'thumbnail' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ], [
            'nm_barang.required' => 'Nama Barang tidak boleh kosong.'
        ]);

        // mass assigment
        Product::create([
            'store_id' => $request->store_id,
            'kategori_id' => $request->kategori_id,
            'nm_barang' => $request->nm_barang,
            'thumbnail' => 'kosong',
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect('products')->with('status', 'Product berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->makeHidden(['store_id', 'kategori_id']);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $stores = Store::all();
        $kategoris = Kategori::all();
        return view('product.edit', compact('product', 'stores', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'store_id' => 'required',
            'kategori_id' => 'required',
            'nm_barang' => 'required|min:2',
            // 'thumbnail' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ], [
            'nm_barang.required' => 'Nama Barang tidak boleh kosong.'
        ]);

        Product::where('id', $product->id)
        ->update([
            'store_id' => $request->store_id,
            'kategori_id' => $request->kategori_id,
            'nm_barang' => $request->nm_barang,
            'thumbnail' => 'kosong',
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect('products')->with('status', 'Product berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // cara 1
        $product->delete();

        return redirect('products')->with('status', 'Product berhasil dihapus!');
    }
}
