<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(auth()->user()->id)->cabangtokos()->first();

        if($user == null){

            abort(404, 'Ada kesalahan anda tidak terdaftar di toko manapun!');
        }
        $barang = Barang::where('cabangtoko_id', $user->id)->get();
        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'stok_barang' => 'required',
            'harga_barang' => 'required',
            'kadarluarsa_barang' => 'required'
        ]);

        
        $cabang = User::find(auth()->user()->id)->cabangtokos()->first();


        $barang = Barang::create([
            "nama_barang" => $request->nama_barang, 
            "stok_barang" => $request->stok_barang, 
            "harga_barang" => $request->harga_barang, 
            "kode_barang" => $request->kode_barang ,
            "kadarluarsa_barang" => $request->kadarluarsa_barang ,
            "cabangtoko_id" => $cabang->id
        
        ]);
        return redirect()->route('barang.index')->with('sukses', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
      
        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'stok_barang' => 'required',
            'harga_barang' => 'required',
            'kadarluarsa_barang' => 'required'
        ]);

        
        $cabang = User::find(auth()->user()->id)->cabangtokos()->first();


        $barang->update([
            "nama_barang" => $request->nama_barang, 
            "stok_barang" => $request->stok_barang, 
            "harga_barang" => $request->harga_barang, 
            "kode_barang" => $request->kode_barang ,
            "kadarluarsa_barang" => $request->kadarluarsa_barang ,
            "cabangtoko_id" => $cabang->id
        
        ]);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
           
        try {
           
    
           
            $barang->delete();
    
          
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
        } catch (QueryException $e) {
        
            return redirect()->route('barang.index')->with('error', 'Gagal menghapus barang. Pastikan tidak ada data yang terkait.');
        }
    }
}
