<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APITransactionController extends Controller
{
    public function index(){
        $data = Transaction::where('user_id', Auth::user()->id)->get();

        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function store(Request $request){
        
        $data = Transaction::create([
            'user_id' => $request->user_id,
            'store_id' => $request->store_id,
            'product_id' => $request->product_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'status' => 'pembayaran'
        ]);
    }

    public function checkout($id){
        $cart = Cart::find($id);
        $data = Transaction::create([
            'user_id' => $cart->user_id,
            'store_id' => $cart->store_id,
            'product_id' => $cart->product_id,
            'jumlah' => $cart->jumlah,
            'harga' => $cart->harga,
            'keterangan' => $cart->keterangan,
            'status' => 'pembayaran'
        ]);
    }

    public function confirmpay($id){

    }

    public function confirmsent($id){

    }

    public function cencel($id){
        
    }
}
