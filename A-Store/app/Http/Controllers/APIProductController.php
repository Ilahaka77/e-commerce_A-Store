<?php

namespace App\Http\Controllers;

use App\Product;
use App\Kategori;
use App\Store;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class APIProductController extends Controller
{
    public function index(){
        $product = Product::with('store','kategori')->get();
        $kategori = Kategori::all();
        if($product->count() == 0){
            return $this->sendResponse('error','data_not_found', [null, $kategori], 404);
        }else{
            return $this->sendResponse('success', 'data_founded', [$product, $kategori], 200);
        }
    }

    public function show($id){
        $data = Product::where('id', $id)->with('store', 'kategori')->get();
        if(is_null($data)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success','data_founded', $data, 200);
        }
    }

    public function showKategori($id){
        $data = Product::where('kategori_id', $id)->get();
        if(is_null($data)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success','data_founded', $data, 200);
        }
    }

    public function showStore(){
        $store = Store::where('user_id', Auth::user()->id)->first();

        $data = Product::where('store_id', $store->id)->get();
        // dd($data);
        if(is_null($data)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            // return $this->sendResponse('success','data_founded', [$store, $data], 200);
            // return $this->sendResponse('success','data_founded', compact('store', 'data'), 200);
            return response()->json(compact('store', 'data'), 200);
        }
    }

    public function store(Request $request){

        $client = new Client();

        $validator = Validator::make($request->all(),[
            'thumbnail' => 'required|image',
            'nm_barang' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required'
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

        $store = Store::where('user_id', Auth::user()->id)->first();
        // dd();

        $data = Product::create([
            'store_id' => $store->id,
            'kategori_id' => $request->kategori,
            'thumbnail' => $gambar,
            'nm_barang' => $request->nm_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        $data->save();
    
        return $this->sendResponse('success', 'insert is success', $data , 201);
    }

    public function update(Request $request, $id){

        $product = Product::find($id);
        $client = new Client();

        $gambar = '';
        if(is_null($request->thumbnail)){
            $gambar = $product->thumbnail;
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
        // dd($gambar);
        }

        $data = Product::where('id', $id)->update([
            'kategori_id' => $request->kategori,
            'thumbnail' => $gambar,
            'nm_barang' => $request->nm_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga
        ]);
        return $this->sendResponse('success', 'update is success', $data , 201);

    }

    public function tambahStok(Request $request, $id){
        $stok = Product::select('stok')->where('id', $id)->first();
        $stok = $stok + $request->stok;

        Product::where('id', $id)->update([
            'stok' => $stok
        ]);

        return $this->sendResponse('success', 'update is success', $stok , 201);
    }

    public function kurangStok(Request $request, $id){
        $stok = Product::select('stok')->where('id', $id)->get();
        $stok = $stok - $request->stok;

        Product::where('id', $id)->update([
            'stok' => $stok
        ]);

        return $this->sendResponse('success', 'update is success', $stok , 201);
    }

    public function destroy($id){
        $product = Product::where('id', $id)->delete();
        return $this->sendResponse('success', 'data has been deleted', $product , 201);
    }
}
