<?php

namespace App\Http\Controllers;

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
}
