<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawaitoko;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();
        $totalhariini = Pengeluaran::where('toko_id', $toko_id->cabangtoko_id)->whereDate('created_at', Carbon::today())->select(DB::raw('sum(harga * kuantitas_pengeluaran) as total'))->first();
        $totalpengeluaran = Pengeluaran::where('toko_id', $toko_id->cabangtoko_id)->select(DB::raw('sum(harga * kuantitas_pengeluaran) as total'))->first();

        $pengeluaran = Pengeluaran::where('toko_id', $toko_id->cabangtoko_id)->with('pegawai')->latest()->get();
        return view('pengeluaran.index', [
            'pengeluaran' => $pengeluaran,
            'totalpengeluaran' => $totalpengeluaran,
            'totalhariini' =>  $totalhariini
        ]);
    }


   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengeluaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama_pengeluaran' => 'required',
            'kuantitas_pengeluaran' => "required",
            'harga' => "required",

        ]);


        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();
        $pengeluaran = Pengeluaran::create([
            "nama_pengeluaran" => $request->nama_pengeluaran,
            "harga" => $request->harga,
            "kuantitas_pengeluaran" => $request->kuantitas_pengeluaran,
            "pegawai_id" => auth()->user()->id,
            "toko_id" => $toko_id->cabangtoko_id
        ]);



        return redirect()->route('pengeluaran.index')->with('sukses', 'pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        //
    }
}
