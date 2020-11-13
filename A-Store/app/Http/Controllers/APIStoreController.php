<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIStoreController extends Controller
{
    public function index(){
        $data = Store::with('user')->get();
        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function store(Request $request){
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

        $gambar = uniqid().'-'.$request->thumbnail->getClientOriginalName();
        $request->thumbnail->move(public_path('img/thumbnail_store'), $gambar);

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
}
