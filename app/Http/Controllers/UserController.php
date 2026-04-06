<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('be.users.index', compact('users'));
    }

    public function create()
    {
        return view('be.users.create', [
            'title' => 'Tambah User'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:15|unique:users,no_hp',
            'jabatan' => 'required|string|in:admin,apoteker,kasir,pemilik,karyawan,kurir'
        ]);

        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan
            ]);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('be.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('be.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'jabatan' => 'required|in:admin,apoteker,kasir,pemilik,karyawan,kurir'
        ]);

        if($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8'
            ]);
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'jabatan' => $request->jabatan
            ];

            if($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
