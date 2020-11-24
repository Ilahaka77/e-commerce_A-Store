<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Store;
use GuzzleHttp\Client;
use App\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APITransactionController extends Controller
{
    public function beli(){
        $data = Transaction::where('user_id', Auth::user()->id)->get();

        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function pesanan(){
        $user_id = Auth::user()->id;
        $store = Store::where('user_id', $user_id)->first();
        $data = Transaction::where('store_id', $store->id)->get();

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

    public function chekout($id){
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
        $cart->delete();
        return $this->sendResponse('success', 'chekout is success', $data, 201);
        
    }

    public function getpay($id){
        $data = Transaction::find($id);
        $id_store = $data->sotre_id;
        $rekening = Store::select('no_rekening', 'pemilik_rekening', 'bank')->where('id', $id_store)->first();
        return $this->sendResponse('success', 'data_founded', $rekening, 200);

    }

    public function payment(Request $request, $id){
        $transaksi = Transaction::find($id);
        $validator = Validator::make($request->all(),[
            'bukti' => 'required|image' 
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $client = new Client();

        $file = base64_encode(file_get_contents($request->bukti));
        $response = $client->request('POST', 'https://freeimage.host/api/1/upload',[
            'form_params' => [
                'key' => '6d207e02198a847aa98d0a2a901485a5',
                'action' => 'upload',
                'source' => $file,
                'format' => 'json'
            ]
        ]);
        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        $gambar = $data->image->url;

        $transaksi->bukti_bayar = $gambar;
        $transaksi->save();
    }

    public function confirmpay($id){
        $data = Transaction::find($id);
        $data->status = 'proses';
        $data->save();
    }

    public function confirmsent($id){
        $data = Transaction::find($id);
        $data->status = 'diterima';
        $data->save();
    }

    public function cencel($id){
        $data = Transaction::find($id);
        $data->status =  'cencel';
        $data->save();
    }
}
