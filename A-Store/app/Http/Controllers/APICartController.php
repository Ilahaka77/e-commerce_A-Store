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
        $data = Cart::where('user_id', Auth::user()->id)->get();
        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
        
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

    public function destroy($id){
        $data = Cart::where('product_id', $id)->first();
        $data->delete();
        return $this->sendResponse('success', 'data has been deleted', $data, 200);
    }
}
