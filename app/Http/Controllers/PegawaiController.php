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
        $userlogin = Auth::user();

        $toko_id = Pegawaitoko::where('user_id', auth()->user()->id)->first();




       
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
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);
        $userlogin = Auth::user();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($userlogin->hasRole('pemilik')) {
            $pegawaitoko = Pegawaitoko::create([
                'user_id' => $user->id,
                'cabangtoko_id' => $request->penempatan,
                'jabatan' => $request->role,
            ]);
        } elseif ($userlogin->hasRole('manajer')) {
            $toko_id = Pegawaitoko::where('user_id', $userlogin->id)->first();
            $pegawaitoko = Pegawaitoko::create([
                'user_id' => $user->id,
                'cabangtoko_id' => $toko_id->cabangtoko_id,
                'jabatan' => $request->role,
            ]);
        }
        $user->assignRole($request->role);


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
        $user = User::find($id);
        $pegawaitoko = Pegawaitoko::where('user_id', $id)->first();
        $toko = Cabangtoko::all();

        return view('pegawai.edit', compact('pegawaitoko', 'user', 'toko'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,name',
            'penempatan' => 'nullable',
        ]);

        // Ambil user yang akan diupdate
        $user = User::findOrFail($id);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password jika ada
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan data user
        $user->save();

        // Ambil data user yang sedang login
        $userlogin = Auth::user();

        // Update data pegawai toko berdasarkan role yang login
        if ($userlogin->hasRole('pemilik')) {
            // Jika role pemilik, maka penempatan dan jabatan mengikuti input
            $pegawaitoko = Pegawaitoko::where('user_id', $user->id)->first();
            $pegawaitoko->update([
                'cabangtoko_id' => $request->penempatan,
                'jabatan' => $request->role,
            ]);
        } elseif ($userlogin->hasRole('manajer')) {
            // Jika role manajer, penempatan mengikuti cabang toko dari user yang login
            $toko_id = Pegawaitoko::where('user_id', $userlogin->id)->first();
            $pegawaitoko = Pegawaitoko::where('user_id', $user->id)->first();

            $pegawaitoko->update([
                'cabangtoko_id' => $toko_id->cabangtoko_id,
                'jabatan' => $request->role,
            ]);
        }

        // Update atau assign ulang role
        // Jika role berubah, hapus role lama dan assign role baru
        $user->syncRoles($request->role);

        // Redirect ke halaman pegawai dengan pesan sukses
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);


        $pegawaitoko = Pegawaitoko::where('user_id', $user->id)->first();
        if ($pegawaitoko) {
            $pegawaitoko->delete();
        }

      
        $user->removeRole($user->getRoleNames()[0]);


        $user->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil Hapus');
    }
}
