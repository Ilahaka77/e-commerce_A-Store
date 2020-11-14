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

    public function store(Request $request){
        $user = Auth::user();
        $client = new Client();
        if($user->role == 'pedagang'){
            return $this->sendResponse('warning', 'sudah punya toko',null, 400);
        }

        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required',
            'nama_toko' => 'required',
            'alamat' => 'required',
            'no_telepon' =>'required',
            'kota' => 'required',
            'kd_pos' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $id = Auth::user()->id;
        $user = User::where('id', $id)->update([
            'role' => 'pedagang'
        ]);

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
        $gambar = $data->display_url;

        $store = Store::create([
            'user_id' => $id,
            'thumbnail' => $gambar,
            'nm_toko' => $request->nama_toko,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kd_pos' => $request->kd_pos
        ]);

        return $this->sendResponse('success', 'store_is_created', $store, 200);
    }

    public function update(){
        
    }
}
