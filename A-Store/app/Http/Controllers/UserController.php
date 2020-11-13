<?php

namespace App\Http\Controllers;

use App\User;
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
        $request->validate([
            'name' => 'required|string|min:2|max:225',
            'email' => 'required',
            'password' => 'required',
            'alamat' => 'required',
            'role' => 'required',
        ], [
            'email' => 'The email field is required.'
        ]);

        user::create([
            'name' => $request->name, 
            'avatar' => 'https://via.placeholder.com/150',
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
        $request->validate([
            'name' => 'required|string|min:2|max:225',
            'email' => 'required',
            'password' => 'required',
            'alamat' => 'required',
            'role' => 'required',
        ], [
            'email' => 'The email field is required.'
        ]);

        User::where('id', $user->id)
            ->update([
                'name' => $request->name, 
                'avatar' => 'https://via.placeholder.com/150',
                'email' => $request->email, 
                'password' => Hash::make($request->get('password')),
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
        //
    }
}
