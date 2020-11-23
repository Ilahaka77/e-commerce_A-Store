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
        $data = Cart::where('user_id', Auth::user()->id)->with('user','product', 'store')->get();
        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
        
    }

    public function store(Request $request, $id){

        $cart = Cart::where('product_id', $id)->with('product')->first();
        if(! $cart){
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
    
            $data->save();
    
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }

        $cart->jumlah = $cart->jumlah + $request->jumlah;
        $cart->harga = $cart->product->harga * $cart->jumlah;
        $cart->save();
        return $this->sendResponse('success', 'data_founded', $cart, 200);

    }

    public function update(Request $request, $id){
        $cart = Cart::where('id', $id)->with('product')->first();
        $cart->jumlah = $request->jumlah;
        $cart->harga = $request->jumlah*$cart->product->harga;
        $cart->keterangan = $request->keterangan;
        $cart->save();
        
        return $this->sendResponse('success', 'data is updated', $cart, 200);


    }

    public function destroy($id){
        $data = Cart::where('id', $id)->first();
        $data->delete();
        return $this->sendResponse('success', 'data has been deleted', $data, 200);
    }
}
