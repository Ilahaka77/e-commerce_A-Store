<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $stores = Store::all();
        $stores = Store::with('user')->paginate(2);

        // Tampilkan data yg telah terhapus baik yg terhapus sementara atau yg tidak terhapus
        // $stores = Store::withTrashed()->get();
        // $stores = Store::onlyTrashed()->get();

        // return $store;
        return view('store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('store.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'thumbnail' => 'image',
            'nm_toko' => 'required|min:5',
            'no_telepon' => 'required',
            'no_rekening' => 'required',
            'pemilik_rekening' => 'required',
            'bank' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kd_pos' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if (is_null($request->thumbnail)) {
            $gambar = 'https://via.placeholder.com/150';
        } else {
            $file = base64_encode(file_get_contents($request->thumbnail));
            $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $file,
                    'format' => 'json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $gambar = $data->image->display_url;
            // dd($gambar);
        }

        // cara 2 : mass assigment
        Store::create([
            'user_id' => $request->user_id,
            'thumbnail' => $gambar,
            'nm_toko' => $request->nm_toko,
            'no_telepon' => $request->no_telepon,
            'no_rekening' => $request->no_rekening,
            'pemilik_rekening' => $request->pemilik_rekening,
            'bank' => $request->bank,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kd_pos' => $request->kd_pos,
        ]);

        return redirect('stores')->with('status', 'Store berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        $products = Product::where('store_id', $store->id)->get();
        // $store = Store::find($id);
        // $store = Store::where('id', $id)->get();
        // $store = $store[0];
        // $store->makeHidden(['user_id']);
        // return $product;
        return view('store.show', compact('store', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        $users = User::all();
        return view('store.edit', compact('store', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'thumbnail' => 'image',
            'nm_toko' => 'required|min:5',
            'no_telepon' => 'required',
            'no_rekening' => 'required',
            'pemilik_rekening' => 'required',
            'bank' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kd_pos' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if (is_null($request->thumbnail)) {
            $gambar = $store->thumbnail;
        } else {
            $file = base64_encode(file_get_contents($request->thumbnail));
            $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $file,
                    'format' => 'json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $gambar = $data->image->display_url;
        }

        Store::where('id', $store->id)
            ->update([
                'user_id' => $request->user_id,
                'thumbnail' => $gambar,
                'nm_toko' => $request->nm_toko,
                'no_telepon' => $request->no_telepon,
                'no_rekening' => $request->no_rekening,
                'pemilik_rekening' => $request->pemilik_rekening,
                'bank' => $request->bank,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'kd_pos' => $request->kd_pos,
            ]);

        return redirect('stores')->with('status', 'Store berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        // cara 1
        $store->delete();

        return redirect('stores')->with('status', 'Store berhasil dihapus!');
    }
}
