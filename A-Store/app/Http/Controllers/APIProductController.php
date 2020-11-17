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

    public function store(Request $request){

        $client = new Client();
        $gambar = '';

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

        $store = Store::select('id')->where('user_id', Auth::user()->id)->get();

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

        $gambar = $product->thumbnail;

        if(!is_null($request->thumbnail)){
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
            'nm_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi
        ]);
    }

    public function tambahStok(Request $request, $id){
        $stok = Product::select('stok')->where('id', $id)->get();
        $stok = $stok + $request->stok;

        Product::where('id', $id)->update([
            'stok' => $stok
        ]);

        return $this->sendResponse('success', 'insert is success', $stok , 201);
    }

    public function kurangStok(Request $request, $id){
        $stok = Product::select('stok')->where('id', $id)->get();
        $stok = $stok - $request->stok;

        Product::where('id', $id)->update([
            'stok' => $stok
        ]);

        return $this->sendResponse('success', 'insert is success', $stok , 201);
    }

    public function delete($id){
        $product = Product::where('id', $id)->delete();
        return $this->sendResponse('success', 'insert is success', $product , 201);
    }
}
