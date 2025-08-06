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
use App\Models\User;

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

    public function laporanformanajer(Request $request)
    {

        $from = $request->from_date;
        $to = $request->to_date;

        // Query penjualan
        $penjualanQuery = Penjualan::join('barangs', 'penjualans.barang_id', '=', 'barangs.id')
            ->join('users', 'penjualans.kasir_id', '=', 'users.id')
            ->select(
                'barangs.*',
                'penjualans.kuantitas',
                'penjualans.harga',
                'penjualans.sisa_stok',
                'users.name',
                'penjualans.created_at as tanggal'
            );

        if ($from && $to) {
            $penjualanQuery->whereBetween('penjualans.created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        $penjualan = $penjualanQuery->latest()->get();

        // Query pengeluaran
        $pengeluaranQuery = Pengeluaran::query();
        if ($from && $to) {
            $pengeluaranQuery->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }
        $pengeluaran = $pengeluaranQuery->latest()->get();

        // Total pendapatan
        $totalPendapatanQuery = Penjualan::join('barangs', 'penjualans.barang_id', '=', 'barangs.id');
        if ($from && $to) {
            $totalPendapatanQuery->whereBetween('penjualans.created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }
        $totalpendapatan = $totalPendapatanQuery
            ->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))
            ->first();

        // Total pengeluaran (yang difilter)
        $totalpengeluaran = $pengeluaran->sum(function ($p) {
            return $p->harga * $p->kuantitas_pengeluaran;
        });

        // Pengeluaran hari ini (tetap tanpa filter)
        $totalPengeluaranHariIni = Pengeluaran::whereDate('created_at', Carbon::today())
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

        // Pengeluaran bulan ini (tetap tanpa filter)
        $totalPengeluaranBulanIni = Pengeluaran::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get()
            ->sum(function ($pengeluaran) {
                return $pengeluaran->harga * $pengeluaran->kuantitas_pengeluaran;
            });

        // Penjualan hari ini (tanpa filter)
        $penjualanhariini = Penjualan::join('barangs', 'penjualans.barang_id', '=', 'barangs.id')
            ->whereDate('penjualans.created_at', Carbon::today())
            ->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))
            ->first();

        return view('laporan.showformanajer', [
            'penjualan' => $penjualan,
            'pengeluaran' => $pengeluaran,
            'totalpendapatan' => $totalpendapatan,
            'totalpengeluaran' => $totalpengeluaran,
            'penjualanhariini' => $penjualanhariini,
            'totalpengeluaranhariini' => $totalPengeluaranHariIni,
            'pengeluaranbulanini' => $totalPengeluaranBulanIni,
            'from' => $from,
            'to' => $to
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

    public function exportPdf(Request $request)
    {

        $from = $request->from_date;
        $to = $request->to_date;

        $penjualan = Penjualan::join('barangs', 'penjualans.barang_id', '=', 'barangs.id')
            ->join('users', 'penjualans.kasir_id', '=', 'users.id')
            ->select(
                'barangs.*',
                'penjualans.kuantitas',
                'penjualans.harga',
                'penjualans.sisa_stok',
                'users.name',
                'penjualans.created_at as tanggal'
            );

        if ($from && $to) {
            $penjualan->whereBetween('penjualans.created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        $data = $penjualan->orderBy('penjualans.created_at', 'desc')->get();

        $totalPenjualan = $data->sum(fn($item) => $item->harga * $item->kuantitas);

        // Format tanggal periode untuk ditampilkan
        $periode = $from && $to
            ? Carbon::parse($from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($to)->translatedFormat('d F Y')
            : 'Semua Periode';

        $tanggalSekarang = Carbon::now()->translatedFormat('d F Y');
        $kepaladesa = User::role('kepaladesa')->first();
        // Generate PDF
        $pdf = Pdf::loadView('penjualan.export', [
            'penjualan' => $data,
            'totalPenjualan' => $totalPenjualan,
            'tanggalSekarang' => $tanggalSekarang,
            'periode' => $periode,
            'kepaladesa' => $kepaladesa
        ]);


        return $pdf->download('laporan_penjualan.pdf');
    }
}
