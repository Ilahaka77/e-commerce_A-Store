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
        
        $request->gambar->move(public_path('img/'), $gambar);

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
}
