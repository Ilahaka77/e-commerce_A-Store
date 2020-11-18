<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APITransactionController extends Controller
{
    public function index(){
        $data = Transaction::where('user_id', Auth::user()->id)->get();

        if($data->count() == 0){
            return $this->sendResponse('error','data_not_found', null, 404);
        }else{
            return $this->sendResponse('success', 'data_founded', $data, 200);
        }
    }

    public function store(Request $request){
        user_id, store_id, product_id, jumlah, harga,keterangan,
    }
}
