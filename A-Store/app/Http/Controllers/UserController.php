<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = user::all();

        return view('user.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:225',
            'avatar' => 'image',
            'email' => 'required',
            'password' => 'required',
            'alamat' => 'required',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if(is_null($request->avatar)){
            $gambar = 'https://via.placeholder.com/150';
        }else{
            $file = base64_encode(file_get_contents($request->avatar));
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
            $gambar = $data->image->display_url;
            // dd($gambar);
        }

        user::create([
            'name' => $request->name, 
            'avatar' => $gambar,
            'email' => $request->email, 
            'password' => Hash::make($request->get('password')),
            'alamat' => $request->alamat, 
            'role' => $request->role,
        ]);

        return redirect('users')->with('status', 'User berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:225',
            'avatar' => 'image',
            'email' => 'required',
            'alamat' => 'required',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if(is_null($request->avatar)){
            $gambar = $user->avatar;
        }else{
            $file = base64_encode(file_get_contents($request->avatar));
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
            $gambar = $data->image->display_url;
        }

        User::where('id', $user->id)
            ->update([
                'name' => $request->name, 
                'avatar' => $gambar,
                'email' => $request->email, 
                'alamat' => $request->alamat, 
                'role' => $request->role,
            ]);

        return redirect('users')->with('status', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('users')->with('status', 'Kategori berhasil dihapus!');
    }
}
