<?php

namespace App\Http\Controllers;

use App\Models\ResearchRequest;
use Illuminate\Http\Request;

class ResearchRequstController extends Controller
{
    //

    public function index()
    {

        $researches = ResearchRequest::all();

        $data = [
            'title' => 'Data Riset Mahasiswa',
            'researches' => $researches
        ];

        return view('admin.research.index', $data);
        // return view('lokasi view',data yang mau di tampilkan kedalam  view)
    }

    public function create()
    {
        return view('admin.research.create');
    }

    public function  store(Request $request)
    {
        //validasi
        $request->validate([
            'student_name' => 'required|string',
            'research_title' => 'required|string',
            'target_institute' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // cek apakah ada file
        if (!$request->hasFile('document_file')) {
            return back()->with('error', 'File tidak ada');
        }

        // upload file
        $file = $request->file('document_file');
        $fileName = $request->input('student_name') . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('research_docs', $fileName, 'public');

        // simpan data
        ResearchRequest::create([
            'student_name' => $request->input('student_name'),
            'research_title' => $request->input('research_title'),
            'target_institute' => $request->input('target_institute'),
            'document_file' => $path
        ]);

        return redirect()->route('researchrequest.index')->with('success', 'Permohonan riset berhasil disimpan');
    }
}
