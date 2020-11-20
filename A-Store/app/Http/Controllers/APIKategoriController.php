<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Kategori;
use Illuminate\Http\Request;

class APIKategoriController extends Controller
{
    public function index(){
        $kategori = Kategori::all();

        if($kategori->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $kategori, 200);
        }
    }

    public function store(Request $request){
        $client = new Client();

        $file = base64_encode(file_get_contents($request->icon));
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

        $data = Kategori::create([
            'icon' => $gambar,
            'kategori' => $request->kategori
        ]);
    }
}
