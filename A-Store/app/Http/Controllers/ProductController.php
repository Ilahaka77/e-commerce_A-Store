<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
use App\Kategori;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'kategori_id' => 'required',
            'nm_barang' => 'required|string|min:2|max:225',
            'thumbnail' => 'image',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if (is_null($request->thumbnail)) {
            $gambar = 'https://via.placeholder.com/150';
        } else {
            $file = base64_encode(file_get_contents($request->thumbnail));
            $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $file,
                    'format' => 'json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $gambar = $data->image->display_url;
            // dd($gambar);
        }

        Product::create([
            'store_id' => $request->store_id,
            'kategori_id' => $request->kategori_id,
            'nm_barang' => $request->nm_barang,
            'thumbnail' => $gambar,
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
        // $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'kategori_id' => 'required',
            'nm_barang' => 'required|min:2',
            'thumbnail' => 'image',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if (is_null($request->thumbnail)) {
            $gambar = $product->thumbnail;
        } else {
            $file = base64_encode(file_get_contents($request->thumbnail));
            $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $file,
                    'format' => 'json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $gambar = $data->image->display_url;
        }
        
        Product::where('id', $product->id)
            ->update([
                'store_id' => $request->store_id,
                'kategori_id' => $request->kategori_id,
                'nm_barang' => $request->nm_barang,
                'thumbnail' => $gambar,
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
