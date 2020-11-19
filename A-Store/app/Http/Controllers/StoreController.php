<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use Illuminate\Http\Request;

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
        $stores = Store::with('user')->paginate(5);

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
        $request->validate([
            'user_id' => 'required',
            'nm_toko' => 'required|min:5',
            'alamat' => 'required',
            'kota' => 'required',
            'kd_pos' => 'required',
        ], [
            'user_id.required' => 'The user field is required.'
        ]);

        // cara 2 : mass assigment
        Store::create([
            'user_id' => $request->user_id, 
            'nm_toko' => $request->nm_toko, 
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
        // $store = Store::find($id);
        // $store = Store::where('id', $id)->get();
        // $store = $store[0];
        $store->makeHidden(['user_id']);
        // return $store;
        return view('store.show', compact('store'));
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
        $request->validate([
            'user_id' => 'required',
            'nm_toko' => 'required|min:3',
        ], [
            'user_id.required' => 'The user field is required.'
        ]);

        Store::where('id', $store->id)
        ->update([
            'user_id' => $request->user_id, 
            'nm_toko' => $request->nm_toko, 
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
