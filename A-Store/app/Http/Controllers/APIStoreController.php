<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIStoreController extends Controller
{
    public function index(){
        $data = Store::all();
        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function show(){
        $id = Auth::user()->id;
        $store = Store::where('user_id', $id)->get();
        if($store->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $store, 200);
        }
    }

    public function store(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $client = new Client();
        if($user->role == 'pedagang'){
            return $this->sendResponse('warning', 'sudah punya toko',null, 400);
        }

        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required|image',
            'nama_toko' => 'required',
            'alamat' => 'required',
            'no_telepon' =>'required|numeric|digits_between:10,13',
            'no_rekening' => 'required',
            'pemilik_rekening' => 'required',
            'bank' => 'required',
            'kota' => 'required',
            'kd_pos' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        

        $file = base64_encode(file_get_contents($request->thumbnail));
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

        $store = Store::create([
            'user_id' => $id,
            'thumbnail' => $gambar,
            'nm_toko' => $request->nama_toko,
            'no_telepon' => $request->no_telepon,
            'no_rekening' => $request->no_rekening,
            'pemilik_rekening' => $request->pemilik_rekening,
            'bank' => $request->bank,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kd_pos' => $request->kd_pos
        ]);
        $user = User::where('id', $id)->update([
            'role' => 'pedagang'
        ]);

        return $this->sendResponse('success', 'store_is_created', $store, 200);
    }

    public function update(Request $request, $id){
        // $store = Store::where('user_id', $id)->get();
        $client = new Client();
        $store = Store::find($id);

        $validator = Validator::make($request->all(), [
            'thumbnail' => 'image',
            'nama_toko' => 'required',
            'alamat' => 'required',
            'no_telepon' =>'required|numeric|digits_between:10,13',
            'no_rekening' => 'required',
            'pemilik_rekening' => 'required',
            'bank' => 'required',
            'kota' => 'required',
            'kd_pos' => 'required|digits:6|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $gambar = '';
        if(is_null($request->thumbnail)){
            $gambar = $store->thumbnail;
        }else{
            $file = base64_encode(file_get_contents($request->thumbnail));
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
        }

        $store->thumbnail = $gambar;
        $store->nm_toko = $request->nama_toko;
        $store->no_telepon = $request->no_telepon;
        $store->no_rekening = $request->no_rekening;
        $store->pemilik_rekening = $request->pemilik_rekening;
        $store->bank = $request->bank;
        $store->alamat = $request->alamat;
        $store->kota = $request->kota;
        $store->kd_pos = $request->kd_pos;

        $store->save();
        return $this->sendResponse('success', 'store is update', $store, 200);

    }
}
