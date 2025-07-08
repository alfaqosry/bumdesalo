<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Laporan;
use App\Models\Penjualan;
use App\Models\Cabangtoko;
use App\Models\Pegawaitoko;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftartoko = Cabangtoko::join('pegawaitoko', 'cabangtokos.id', '=', 'pegawaitoko.cabangtoko_id')
            ->join('users', 'pegawaitoko.user_id', '=', 'users.id')
            ->select('users.name', 'cabangtokos.nama_cabang', 'cabangtokos.alamat_cabang', 'cabangtokos.id')->where('pegawaitoko.jabatan', 'manajer')
            ->get();

        return view('laporan.index', ['daftartoko' => $daftartoko]);
    }

    public function laporanformanajer()
    {

        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();
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
            ->where('penjualans.toko_id', $toko_id->cabangtoko_id)
            ->latest()
            ->get();



        $pengeluaran = Pengeluaran::where('toko_id', $toko_id->cabangtoko_id)->latest()
            ->get();

        $totalPengeluaranHariIni = Pengeluaran::where('toko_id', $toko_id->cabangtoko_id)
            ->whereDate('created_at', Carbon::today()) // Filter untuk hari ini
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

        $totalPengeluaranBulanIni = Pengeluaran::where('toko_id', $toko_id->cabangtoko_id)
            ->whereMonth('created_at', Carbon::now()->month) // Filter bulan saat ini
            ->whereYear('created_at', Carbon::now()->year)   // Filter tahun saat ini
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

        $penjualanhariini = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->where('penjualans.toko_id', $toko_id->cabangtoko_id)->whereDate('penjualans.created_at', Carbon::today())->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        $totalpendapatan = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->where('penjualans.toko_id', $toko_id->cabangtoko_id)->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();

        $toko = Cabangtoko::find($toko_id->cabangtoko_id);
        return view('laporan.showformanajer', [
            'penjualan' => $penjualan,
            'penjualanhariini' => $penjualanhariini,
            'totalpendapatan' => $totalpendapatan,
            'toko' => $toko,
            'pengeluaran' =>  $pengeluaran,
            'totalpengeluaranhariini' => $totalPengeluaranHariIni,
            'pengeluaranbulanini' => $totalPengeluaranBulanIni
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
            ->where('penjualans.toko_id', $id)
            ->latest()
            ->get();

        $penjualanhariini = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->where('penjualans.toko_id', $id)->whereDate('penjualans.created_at', Carbon::today())->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        $totalpendapatan = Penjualan::join(
            'barangs',
            'penjualans.barang_id',
            '=',
            'barangs.id'
        )->where('penjualans.toko_id', $id)->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        $toko = Cabangtoko::find($id);

        $pengeluaran = Pengeluaran::where('toko_id', $id)->latest()
            ->get();

        $totalPengeluaranHariIni = Pengeluaran::where('toko_id', $id)
            ->whereDate('created_at', Carbon::today()) // Filter untuk hari ini
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

        $totalPengeluaranBulanIni = Pengeluaran::where('toko_id', $id)
            ->whereMonth('created_at', Carbon::now()->month) // Filter bulan saat ini
            ->whereYear('created_at', Carbon::now()->year)   // Filter tahun saat ini
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });
        return view('laporan.show', [
            'penjualan' => $penjualan,
            'penjualanhariini' => $penjualanhariini,
            'totalpendapatan' => $totalpendapatan,
            'toko' => $toko,
            'pengeluaran' =>  $pengeluaran,
            'totalpengeluaranhariini' => $totalPengeluaranHariIni,
            'pengeluaranbulanini' => $totalPengeluaranBulanIni
        ]);
    }


    public function get_penjualan($id)
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
            ->where('penjualans.toko_id', $id)
            ->latest()
            ->get();

        return response()->json(['penjualan' =>  $penjualan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        //
    }

    public function exportPdf()
    {
        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();
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
            ->where('penjualans.toko_id', $toko_id->cabangtoko_id)
            ->latest()
            ->get();

        // Load view untuk PDF
        $pdf = Pdf::loadView('penjualan.export', compact('penjualan'));

        // Return sebagai download file PDF
        return $pdf->download('laporan_penjualan.pdf');
    }

}
