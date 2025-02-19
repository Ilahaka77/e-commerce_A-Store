<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class APIMessageController extends Controller
{
    public function user(){

        // $user = DB::select("SELECT  users.id, users.name, users.avatar, users.email, max(messages.created_at) as tanggal from users 
        // LEFT JOIN messages ON (users.id = messages.from OR users.id = messages.to)
        // where users.id != ".Auth::user()->id ." AND (messages.to = ". Auth::user()->id ." OR messages.from = ". Auth::user()->id .") 
        // group by users.id, users.name, users.avatar, users.email");
        
        $user = User::leftJoin('messages', function($join){
            $join->on('users.id', '=', 'messages.from')->orOn('users.id', '=', 'messages.to');
        })->where('users.id','!=' ,Auth::user()->id)->where(function($query){
            $query->where('messages.from', '=', Auth::user()->id)->orWhere('messages.to', '=', Auth::user()->id);
        })->select('users.id', 'users.name', 'users.avatar', 'users.email', DB::raw('max(messages.created_at) as tanggal'))
        ->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')->get();

        $unread = DB::select("SELECT users.id, count('is_read') as unread from users 
        LEFT JOIN messages ON users.id = messages.from and is_read = 0 
        where users.id != ".Auth::user()->id ." AND messages.to = ". Auth::user()->id ." 
        group by users.id, users.name, users.avatar, users.email");

        $cart = Cart::select(DB::raw('count(id) as cart'))->where('user_id', Auth::user()->id)->first();


        // $user = User::select('users.id', 'users.name', 'users.avatar', 'users.email', DB::raw('COUNT(is_read) as unread'))->leftJoin('messages', 'users.id', '=', 'messages.to')->where('users.id', '!=', Auth::user()->id)->where('messages.to', Auth::user()->id)->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')->get();

        return $this->sendResponse('success', 'data is founded', ['user'=>$user,'notif'=>$unread], 200);

        return response()->json(compact('user', 'unread', 'cart'), 200);
        
    }

    public function getMessage($user_id){

        $my_id = Auth::user()->id;

        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $pesan = Message::where(function($query) use ($user_id, $my_id){
            $query->where('from', $my_id)->where('to', $user_id);
        })->orWhere(function($query) use ($user_id, $my_id){
            $query->where('from', $user_id)->where('to', $my_id);
        })->get();

        return response()->json(compact('pesan'), 200);

    }

    public function sentMessage(Request $request, $id){
        $from = Auth::user()->id;
        $to = $id;
        $pesan = $request->pesan;

        $data = Message::create([
            'from' => $from,
            'to' => $to,
            'message' => $pesan,
            'is_read' => 0
        ]);

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '181fcc3c876309e9f9d4',
            '48b0f1a1cfc9bc4c68fb',
            '1114218',
            $options
        );
        
        $pusher->trigger('my-channel', 'my-event', $data);;
        return response()->json($data, 200);
    }
}
