<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
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

    public function store(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_toko' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kd_pos' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $store = Store::create([
            'user_id' => $id,
            'nm_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kd_pos' => $request->kd_pos
        ]);

        return response()->json(compact('store'),201);
    }
}
