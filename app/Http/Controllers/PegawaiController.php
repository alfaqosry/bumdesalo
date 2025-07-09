<?php

namespace App\Http\Controllers;

use App\Models\Cabangtoko;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Pegawaitoko;

use Illuminate\Http\Request;
use Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('pegawai.index', [

            'pegawai' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'tanggal_rekrut' => 'nullable|date|before_or_equal:today',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_rekrut' => $request->tanggal_rekrut,
        ]);



        $user->assignRole("pegawai");


        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = User::find($id);


        return view('pegawai.edit', compact( 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'tanggal_rekrut' => 'nullable|date|before_or_equal:today',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_rekrut' => $request->tanggal_rekrut,
        ]);

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }


        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data user berhasil dihapus.');
    }
}
