<?php

namespace App\Http\Controllers;

use App\User;
use App\Store;
use App\Product;
use App\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesanans = Transaction::where('status', '!=', 'diterima')->with('product', 'user')->paginate(4);
        // dd($pesanans);
        return view('pesanan.index', compact('pesanans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $pesanan)
    {
        $pesanan->makeHidden(['user_id', 'product_id']);

        return view('pesanan.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirmpay($id)
    {
        $data = Transaction::find($id);
        $product = Product::where('id', $data->product_id)->first();
        $data->status = 'packing';
        $data->save();

        $product->stok = $product->stok - $data->jumlah;
        $product->save();

        // dd($data);
        // dd($product);

        return redirect('pesanans')->with('status', 'Status Sedang di kemas!');
    }

    public function kd_resi($id){
        return view('pesanan.kd_resi', compact('id'));
        
    }

    public function sending(Request $request, $id)
    {
        $data = Transaction::find($id);
        $data->status = 'pengiriman';
        $data->kd_resi = $request->kd_resi;
        $data->save();

        // dd($data);

        return redirect('pesanans')->with('status', 'Status Sedang di kirim!');

    }
}
