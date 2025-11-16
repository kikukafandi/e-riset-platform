<?php

namespace App\Http\Controllers;

use App\Models\TopikRiset;
use Illuminate\Http\Request;

class TopikRisetController extends Controller
{
    public function index()
    {
        $topikRiset = TopikRiset::all();
        // Kita akan buat view ini di Langkah 4
        return view('dashboard.manage-topik.index', compact('topikRiset'));
    }

    public function create()
    {
        // Kita akan buat view ini di Langkah 4
        return view('dashboard.manage-topik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_topik' => 'required|string|max:255|unique:topik_risets,nama_topik',
            'deskripsi'  => 'nullable|string',
        ]);

        TopikRiset::create($request->all());

        return redirect()->route('manage.topik.index') // Kita akan buat route ini di Langkah 3
            ->with('success', 'Topik riset berhasil ditambahkan!');
    }

    public function edit($id) // Terima $id
    {
        $topik = TopikRiset::findOrFail($id);
        // Kita akan buat view ini di Langkah 4
        return view('dashboard.manage-topik.edit', compact('topik'));
    }

    public function update(Request $request, $id) // Terima $id
    {
        $topik = TopikRiset::findOrFail($id);
        $request->validate([
            'nama_topik' => 'required|string|max:255|unique:topik_risets,nama_topik,' . $topik->id,
            'deskripsi'  => 'nullable|string',
        ]);

        $topik->update($request->all());

        return redirect()->route('manage.topik.index')
            ->with('success', 'Topik riset berhasil diperbarui!');
    }

    public function destroy($id) // Terima $id
    {
        $topik = TopikRiset::findOrFail($id);
        $topik->delete();

        return redirect()->route('manage.topik.index')
            ->with('success', 'Topik riset berhasil dihapus!');
    }

    // Metode show() tidak kita pakai, biarkan saja
    public function show(TopikRiset $topikRiset) {}
}
