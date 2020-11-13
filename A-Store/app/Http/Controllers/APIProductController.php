<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class APIProductController extends Controller
{
    public function index(){
        $data = Product::with('store')->with('kategori')->get();
        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function store(Request $request){
        $gambar = uniqid().'-'.$request->gambar->getClientOriginalName();
        
        $request->gambar->move(public_path('img/thumbnail'), $gambar);

        $data = Product::create([
            'store_id' => 1,
            'kategori_id' => 1,
            'thumbnail' => $gambar,
            'nm_barang' => $request->nm_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        $data->save();
    
        return $this->sendResponse('success', 'insert is success', $data , 201);
    }

    public function update(Request $request, $id){

        $product = Product::find($id);

        $gambar = $product->thumbnail;
        // dd($gambar);
        if($request->thumbnail !== null){
            $request->thumbnail->move(public_path('img/thumbnail'), $gambar);
        }

        $data = Product::where('id', $id)->update([
            'kategori_id' => $request->kategori,
            'thumbnail' => $gambar,
            'nm_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi
        ]);
    }

    public function tambahStok(Request $request, $id){
        $stok = Product::select('stok')->where('id', $id)->get();
        $stok = $stok + $request->stok;

        Product::where('id', $id)->update([
            'stok' => $stok
        ]);

        return $this->sendResponse('success', 'insert is success', $stok , 201);
    }

    public function kurangStok(Request $request, $id){
        $stok = Product::select('stok')->where('id', $id)->get();
        $stok = $stok - $request->stok;

        Product::where('id', $id)->update([
            'stok' => $stok
        ]);

        return $this->sendResponse('success', 'insert is success', $stok , 201);
    }

    public function delete($id){
        $product = Product::where('id', $id)->delete();
        return $this->sendResponse('success', 'insert is success', $product , 201);
    }
}
