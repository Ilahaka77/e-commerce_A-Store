<?php

namespace App\Http\Controllers;

use App\Kategori;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = Kategori::paginate(5);

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris = Kategori::all();

        return view('kategori.create', compact('kategoris'));
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
            'icon' => 'image',
            'kategori' => 'required|string|min:5|max:225',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if(is_null($request->icon)){
            $gambar = 'https://via.placeholder.com/150';
        }else{
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
            $gambar = $data->image->display_url;
            // dd($gambar);
        }

        kategori::create([
            'icon' => $gambar, 
            'kategori' => $request->kategori, 
        ]);

        return redirect('kategoris')->with('status', 'Kategori berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $gambar = '';
        $client = new Client();

        $validator = Validator::make($request->all(), [
            'icon' => 'image',
            'kategori' => 'required|string|min:5|max:225',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            if(is_null($request->icon)){
                $gambar = $kategori->icon;
            }else{
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
                $gambar = $data->image->display_url;
            }

        // cara 1
        // $kategori->kategori = $request->kategori;
        // $kategori->save();

        // cara 2
        Kategori::where('id', $kategori->id)
            ->update([
                'icon' => $gambar,
                'kategori' => $request->kategori,
            ]);

            return redirect('kategoris')->with('status', 'Kategori berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect('kategoris')->with('status', 'Kategori berhasil dihapus!');
    }
}
