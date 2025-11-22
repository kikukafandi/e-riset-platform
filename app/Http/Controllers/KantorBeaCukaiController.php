<?php

namespace App\Http\Controllers;

use App\Models\KantorBeaCukai;
use Illuminate\Http\Request;

class KantorBeaCukaiController extends Controller
{
    public function index()
    {
        $kantors = KantorBeaCukai::where('is_active', true)
            ->orderBy('provinsi')
            ->orderBy('nama_kantor')
            ->paginate(20);
        
        return view('dashboard.manage-kantor.index', compact('kantors'));
    }

    public function create()
    {
        return view('dashboard.manage-kantor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'kode_kantor' => 'required|string|max:50|unique:kantor_bea_cukai',
            'provinsi' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kantor' => 'required|in:kanwil,kppbc,kpu'
        ]);

        KantorBeaCukai::create($request->all());

        return redirect()->route('manage.kantor.index')
            ->with('success', 'Kantor Bea Cukai berhasil ditambahkan');
    }

    public function show(KantorBeaCukai $kantor)
    {
        return view('dashboard.manage-kantor.show', compact('kantor'));
    }

    public function edit(KantorBeaCukai $kantor)
    {
        return view('dashboard.manage-kantor.edit', compact('kantor'));
    }

    public function update(Request $request, KantorBeaCukai $kantor)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'kode_kantor' => 'required|string|max:50|unique:kantor_bea_cukai,kode_kantor,' . $kantor->id,
            'provinsi' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kantor' => 'required|in:kanwil,kppbc,kpu'
        ]);

        $kantor->update($request->all());

        return redirect()->route('manage.kantor.index')
            ->with('success', 'Kantor Bea Cukai berhasil diperbarui');
    }

    public function destroy(KantorBeaCukai $kantor)
    {
        // Soft delete by setting is_active to false
        $kantor->update(['is_active' => false]);

        return redirect()->route('manage.kantor.index')
            ->with('success', 'Kantor Bea Cukai berhasil dinonaktifkan');
    }

    // API endpoint for getting kantor options
    public function getKantorOptions(Request $request)
    {
        $query = KantorBeaCukai::where('is_active', true);

        if ($request->has('provinsi') && $request->provinsi) {
            $query->where('provinsi', $request->provinsi);
        }

        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis_kantor', $request->jenis);
        }

        $kantors = $query->orderBy('nama_kantor')->get();

        return response()->json($kantors);
    }

    // Get unique provinces
    public static function getProvinces()
    {
        return KantorBeaCukai::where('is_active', true)
            ->distinct()
            ->orderBy('provinsi')
            ->pluck('provinsi');
    }
}