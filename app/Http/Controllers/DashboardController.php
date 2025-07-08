<?php

namespace App\Http\Controllers;

use App\Helpers\Grafik;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Dashboard;
use App\Models\Penjualan;
use App\Models\Cabangtoko;
use App\Models\Pegawaitoko;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userlogin = Auth::user();
        $pegawaitoko = Pegawaitoko::where('user_id', Auth()->user()->id)->first();
        $totaltoko = "11";
        $totalpegawai = User::count();

        if ($userlogin->hasRole('kepaladesa')) {
            $totalpenjualan = Penjualan::count();
        } else {
            $totalpenjualan = Penjualan::count();
        }



        $penjualans = Penjualan::select('id', 'created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            });


        $pengeluaran = Pengeluaran::select('id', 'created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            });



        if ($userlogin->hasRole('pemilik')) {
            $totalpendapatan = Penjualan::join(
                'barangs',
                'penjualans.barang_id',
                '=',
                'barangs.id'
            )->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        } else {

            $totalpendapatan = Penjualan::join(
                'barangs',
                'penjualans.barang_id',
                '=',
                'barangs.id'
            )->select(DB::raw('sum(barangs.harga_barang * penjualans.kuantitas) as total'))->first();
        }
        // return response()->json(array_values($penjualanArr));


        return view(
            'dashboard.index',
            [
                'totaltoko' => $totaltoko,
                'totalpegawai' => $totalpegawai,
                'totalpenjualan' => $totalpenjualan,
                'penjualanArr' => Grafik::get_grafik($penjualans),
                'pengeluaranArr' => Grafik::get_grafik($pengeluaran),
                'totalpendapatan' => $totalpendapatan
            ]
        );
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
