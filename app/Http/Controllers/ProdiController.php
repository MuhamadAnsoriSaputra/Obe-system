<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $prodis = Prodi::when($keyword, function ($query) use ($keyword) {
            $query->where('kode_prodi', 'like', "%$keyword%")
                ->orWhere('nama_prodi', 'like', "%$keyword%")
                ->orWhere('jenjang', 'like', "%$keyword%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('prodis.index', compact('prodis', 'keyword'));
    }


    public function create()
    {
        return view('prodis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodis,kode_prodi',
            'nama_prodi' => 'required|string|max:100',
            'jenjang' => 'required|string|in:D3,D4,S1,S2',
        ]);

        Prodi::create($request->only(['kode_prodi', 'nama_prodi', 'jenjang']));

        return redirect()->route('prodis.index')->with('success', 'Prodi berhasil ditambahkan');
    }

    public function edit(Prodi $prodi)
    {
        return view('prodis.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodis,kode_prodi,' . $prodi->kode_prodi . ',kode_prodi',
            'nama_prodi' => 'required|string|max:100',
            'jenjang' => 'required|string|in:D3,D4,S1,S2',
        ]);

        $prodi->update($request->only(['nama_prodi', 'jenjang']));

        return redirect()->route('prodis.index')->with('success', 'Prodi berhasil diperbarui');
    }

    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('prodis.index')->with('success', 'Prodi berhasil dihapus');
    }
}
