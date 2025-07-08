<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Pegawaitoko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $penjualan = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->join(
            'users',
            'penjualans.kasir_id',
            '=',
            'users.id'
        )->select('barangs.*', 'penjualans.kuantitas', 'penjualans.harga', 'penjualans.sisa_stok', 'users.name', 'penjualans.created_at as tanggal')
            ->latest()->get();

        $totalhariini = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->whereDate('penjualans.created_at', Carbon::today())->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        $totalpendapatan = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();




        return view('penjualan.index', ['penjualan' => $penjualan, 'totalhariini' => $totalhariini, 'totalpendapatan' => $totalpendapatan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {



        $barang = Barang::all();
        return view('penjualan.create', ['barangs' => $barang]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);
        $request->validate([
            'barang_id' => 'required',
            'kuantitas' => "required",

        ]);

        $sisastok =  $barang->stok_barang - $request->kuantitas;
        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();
        $penjualan = Penjualan::create([
            "barang_id" => $request->barang_id,
            "harga" => $barang->harga_barang,
            "sisa_stok" => $sisastok,
            "kuantitas" => $request->kuantitas,
            "kasir_id" => auth()->user()->id,
            "toko_id" => $toko_id->cabangtoko_id
        ]);



        $barang->stok_barang = $sisastok;
        $barang->save();

        return redirect()->route('penjualan.index')->with('sukses', 'Penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        $barang = Barang::all();
        return view('penjualan.edit', compact('penjualan', 'barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'barang_id' => 'required',
            'kuantitas' => "required",

        ]);
        $barang = Barang::findOrFail($request->barang_id);
        $sisastok =  $barang->stok_barang - $request->kuantitas;
        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();
        $penjualan->update([
            "barang_id" => $request->barang_id,
            "harga" => $barang->harga_barang,
            "sisa_stok" => $sisastok,
            "kuantitas" => $request->kuantitas,
            "kasir_id" => auth()->user()->id,
            "toko_id" => $toko_id->cabangtoko_id
        ]);

        return redirect()->route('penjualan.index')->with('sukses', 'Penjualan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
