<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabangtoko;
use App\Models\Pegawaitoko;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CabangtokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $cabang = Cabangtoko::with('pegawais')->get();


        // $cabang = Cabangtoko::join('pegawaitoko', 'cabangtokos.id', '=' , 'pegawaitoko.cabangtoko_id')
        //                      ->join('users', 'pegawaitoko.user_id', '=', 'users.id')
        //                      ->select('users.name','cabangtokos.*')->where('pegawaitoko.jabatan', '=', 'manajer')
        //                      ->get();

        $cabang = Cabangtoko::all();

                             
        return view('cabangtoko.index',[
            'cabang' => $cabang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        
        return view('cabangtoko.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required',
            'alamat_cabang' => 'required'
        ]);

       

        $cabangtoko = Cabangtoko::create(["nama_cabang" => $request->nama_cabang, "alamat_cabang" => $request->alamat_cabang]);
        // $pegawai = Pegawaitoko::create(["user_id" => $request->manajer, "cabangtoko_id" => $cabangtoko->id, "jabatan" => "manajer"]); 
        return redirect()->route('cabang.index')->with('sukses', 'Cabang Toko berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabangtoko $cabangtoko)
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
            ->where('penjualans.toko_id', $cabangtoko->id)
            ->latest()
            ->get();

        $penjualanhariini = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->where('penjualans.toko_id', $cabangtoko->id)->whereDate('penjualans.created_at', Carbon::today())->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        $totalpendapatan = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->where('penjualans.toko_id', $cabangtoko->id)->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
      

        $pengeluaran = Pengeluaran::where('toko_id', $cabangtoko->id)->latest()
            ->get();

        $totalPengeluaranHariIni = Pengeluaran::where('toko_id', $cabangtoko->id)
            ->whereDate('created_at', Carbon::today()) // Filter untuk hari ini
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

        $totalPengeluaranBulanIni = Pengeluaran::where('toko_id', $cabangtoko->id)
            ->whereMonth('created_at', Carbon::now()->month) // Filter bulan saat ini
            ->whereYear('created_at', Carbon::now()->year)   // Filter tahun saat ini
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

            $barang = Barang::where('cabangtoko_id', $cabangtoko->id)->get();
        return view('cabangtoko.show', [
            'penjualan' => $penjualan,
            'penjualanhariini' => $penjualanhariini,
            'totalpendapatan' => $totalpendapatan,
            'toko' => $cabangtoko,
            'pengeluaran' =>  $pengeluaran,
            'totalpengeluaranhariini' => $totalPengeluaranHariIni,
            'pengeluaranbulanini' => $totalPengeluaranBulanIni,
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabangtoko $cabangtoko)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cabangtoko $cabangtoko)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabangtoko $cabangtoko)
    {
        //
    }
}
