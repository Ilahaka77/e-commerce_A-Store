<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Store;
use GuzzleHttp\Client;
use App\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APITransactionController extends Controller
{
    public function beli(){
        $data = Transaction::where('user_id', Auth::user()->id)->with('product', 'store')->get();

        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function pesanan(){
        $user_id = Auth::user()->id;
        $store = Store::where('user_id', $user_id)->first();
        $data = Transaction::where('store_id', $store->id)->with('product','user')->get();

        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function chekout(Request $request, $id){
        $cart = Cart::find($id);
        $data = Transaction::create([
            'user_id' => $cart->user_id,
            'store_id' => $cart->store_id,
            'product_id' => $cart->product_id,
            'jumlah' => $cart->jumlah,
            'harga' => $cart->harga,
            'keterangan' => $cart->keterangan,
            'pengiriman' => $request->pengiriman,
            'status' => 'pembayaran',
            'bukti_bayar' => 'https://via.placeholder.com/150'
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
        $transaksi->status = 'sudah dibayar';
        $transaksi->save();

        return $this->sendResponse('success', 'pembayaran berhasil', null, 201);
    }

    public function confirmpay($id){
        $data = Transaction::find($id);
        $product = Product::where('id', $data->product_id)->first();
        $data->status = 'packing';
        $data->save();

        $product->stok = $product->stok - $data->jumlah;
        $product->save();

        return $this->sendResponse('success', 'Beralih ke pembungkusan', null, 200);

    }

    public function sending($id){
        $data = Transaction::find($id);
        $data->status = 'pengiriman';
        $data->save();
        return $this->sendResponse('success', 'Beralih ke Pengiriman', null, 200);

    }

    public function confirmsent($id){
        $data = Transaction::find($id);
        $data->status = 'diterima';
        $data->save();
        return $this->sendResponse('success', 'Barang sudah diterima', null, 200);

    }

    public function destroy($id){
        $data = Transaction::find($id);
        $data->delete();

        return $this->sendResponse('success', 'Data has been deleted', null, 200);
    }
}
