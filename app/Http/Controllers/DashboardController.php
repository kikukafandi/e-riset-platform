<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $permohonans = DokumenPermohonan::with('user')->latest()->get();
        return view('dashboard.index', compact('permohonans'));
    }


    public function create(){
        return view('dashboard.form-permohonan');
    }
}
