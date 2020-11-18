<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APICartController extends Controller
{
    public function index(){
        
        
    }

    public function store(Request $request, $id){
        $user = Auth::user()->id;
        $product = Product::where('id', $id)->with('store')->first();
        $store = $product->store_id;
        $harga = $product->harga * $request->jumlah;
        
        $data = Cart::create([
            'user_id' => $user,
            'store_id' => $store,
            'product_id' => $product->id,
            'jumlah' => $request->jumlah,
            'harga' => $harga,
            'keterangan' => $request->keterangan
        ]);

        return $this->sendResponse('success', 'data_founded', $data, 200);
    }
}
