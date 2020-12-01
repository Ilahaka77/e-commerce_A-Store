<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
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

        $user = DB::select("SELECT  users.id, users.name, users.avatar, users.email,DATE_FORMAT(max(messages.created_at), '%d/%m/%Y') as tanggal from users 
        LEFT JOIN messages ON (users.id = messages.from OR users.id = messages.to)
        where users.id != ".Auth::user()->id ." AND (messages.to = ". Auth::user()->id ." OR messages.from = ". Auth::user()->id .") 
        group by users.id, users.name, users.avatar, users.email");

        $unread = DB::select("SELECT users.id, count('is_read') as unread from users 
        LEFT JOIN messages ON users.id = messages.from and is_read = 0 
        where users.id != ".Auth::user()->id ." AND messages.to = ". Auth::user()->id ." 
        group by users.id, users.name, users.avatar, users.email");

        // $user = User::select('users.id', 'users.name', 'users.avatar', 'users.email', DB::raw('COUNT(is_read) as unread'))->leftJoin('messages', 'users.id', '=', 'messages.to')->where('users.id', '!=', Auth::user()->id)->where('messages.to', Auth::user()->id)->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')->get();

        return $this->sendResponse('success', 'data is founded', ['user'=>$user,'notif'=>$unread], 200);

        return response()->json(compact('user', 'unread'), 200);
        
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

        $option = [
            'cluster' => 'ap1',
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $option
        );

        // $data = ['from' => $from, 'to' => $to];
        $pusher->trigger('my-channel', 'my-event', $data);
        return response()->json($data, 200);
    }
}
