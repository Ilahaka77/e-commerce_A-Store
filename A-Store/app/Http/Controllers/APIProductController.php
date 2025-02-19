<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Kategori;
use App\Store;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class APIProductController extends Controller
{
    public function index(){
        // $product = Product::with('store','kategori','store.user')->orderBy('created_at', 'desc')->get();
        $product = Product::select('products.*', DB::raw('sum(histories.jumlah) as terjual'))->leftJoin('histories', 'histories.product_id', '=', 'products.id')->with('store', 'kategori', 'store.user')->groupBy('products.id')->orderBy('products.created_at', 'desc')->get();

        $kategori = Kategori::all();

        $cart = Cart::select(DB::raw('count(id) as cart'))->where('user_id', Auth::user()->id)->first();
        if($product->count() == 0){
            return $this->sendResponse('error','data_not_found', [null, $kategori], 404);
        }else{
            return $this->sendResponse('success', 'data_founded', [$product, $kategori, $cart], 200);
        }
    }

    public function show($id){
        $product = Product::where('id', $id)->with('kategori')->first();
        $store = Store::where('id', $product->store_id)->with('user')->first();
        if(is_null($product)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success','data_founded', ['product'=>$product, 'store'=>$store], 200);
        }
    }

    public function showKategori($id){
        // $data = Product::where('kategori_id', $id)->with('store')->get();
        $data = Product::select('products.*', DB::raw('sum(histories.jumlah) as terjual'))->leftJoin('histories', 'histories.product_id', '=', 'products.id')->where('products.kategori_id', $id)->with('store', 'kategori', 'store.user')->groupBy('products.id')->orderBy('products.created_at', 'desc')->get();
        
        if(is_null($data)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success','data_founded', $data, 200);
        }
    }

    public function showStore(){
        $store = Store::where('user_id', Auth::user()->id)->first();

        // $data = Product::where('store_id', $store->id)->orderBy('created_at', 'desc')->get();
        $data = Product::select('products.*', DB::raw('sum(histories.jumlah) as terjual'))->leftJoin('histories', 'histories.product_id', '=', 'products.id')->where('products.store_id', $store->id)->with('kategori', 'store.user')->groupBy('products.id')->orderBy('products.created_at', 'desc')->get();

        // dd($data);
        if(is_null($data)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            // return $this->sendResponse('success','data_founded', [$store, $data], 200);
            // return $this->sendResponse('success','data_founded', compact('store', 'data'), 200);
            return response()->json(compact('store', 'data'), 200);
        }
    }

    public function search(Request $request){
        $data = Product::select('products.*', DB::raw('sum(histories.jumlah) as terjual'))->leftJoin('histories', 'histories.product_id', '=', 'products.id')->with('store', 'kategori', 'store.user')->where('nm_barang', 'like', '%'.$request->cari.'%')->groupBy('products.id')->orderBy('products.created_at', 'desc')->get();
        
        // $data = Product::where('nm_barang', 'like', '%'.$request->cari.'%')->with('store','kategori')->get();
        if(is_null($data)){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            // return $this->sendResponse('success','data_founded', [$store, $data], 200);
            // return $this->sendResponse('success','data_founded', compact('store', 'data'), 200);
            return response()->json(compact('data'), 200);
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
        $product = Product::where('id', $id)->first();
        $product->stok = $product->stok + $request->stok;
        $product->save();

        return $this->sendResponse('success', 'update is success', $product , 201);
    }

    public function kurangStok(Request $request, $id){
        $product = Product::where('id', $id)->first();
        $product->stok = $product->stok - $request->stok;
        $product->save();
        return $this->sendResponse('success', 'update is success', $product , 201);
    }

    public function destroy($id){
        $product = Product::where('id', $id)->delete();
        return $this->sendResponse('success', 'data has been deleted', $product , 201);
    }
}
