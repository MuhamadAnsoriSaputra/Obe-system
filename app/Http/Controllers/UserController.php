<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('prodi')->oldest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        return view('users.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'kode_prodi' => 'nullable|exists:prodis,kode_prodi',
        ]);

        $kode_prodi = in_array($request->role, ['akademik', 'kaprodi'])
            ? $request->kode_prodi
            : null;

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kode_prodi' => $kode_prodi,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id_user)
    {
        $user = User::findOrFail($id_user);
        $prodis = Prodi::all();
        return view('users.edit', compact('user', 'prodis'));
    }

    public function update(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'role' => 'required',
            'kode_prodi' => 'nullable|exists:prodis,kode_prodi',
        ]);

        $kode_prodi = in_array($request->role, ['akademik', 'kaprodi'])
            ? $request->kode_prodi
            : null;

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'kode_prodi' => $kode_prodi,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
