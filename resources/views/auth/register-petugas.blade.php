<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Petugas - Platform E-Riset DJBC</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0F2A44',
                        gold: '#D4AF37',
                        slate: {
                            950: '#0A1A2C'
                        }
                    },
                    fontFamily: {
                        sans: ['"Source Sans 3"', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Source Sans 3', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen py-12 px-6">
        <div class="max-w-3xl mx-auto">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg text-white font-bold text-lg"><img src="{{ asset('storage/img/Lambang_Bea_dan_Cukai.png') }}" alt="DJBC Logo" class="h-10 w-10 rounded-lg object-cover"></div>
                    <div class="text-left">
                        <p class="text-xs font-semibold text-gold tracking-wide">DIREKTORAT JENDERAL</p>
                        <p class="text-base font-bold text-navy leading-tight">Bea dan Cukai</p>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-navy mb-2">Registrasi Akun Petugas</h1>
                <p class="text-slate-600">Platform E-Riset DJBC</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy/10 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-navy">Form Registrasi Petugas</h2>
                            <p class="text-xs text-slate-600">Lengkapi data untuk membuat akun petugas</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8">

                    @if(session('success'))
                        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.petugas') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Data Pribadi -->
                        <div>
                            <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Data Pribadi</h3>
                            <div class="space-y-4">
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                                        <input type="text" name="nama" value="{{ old('nama') }}" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                            placeholder="Nama lengkap petugas">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIP <span class="text-red-600">*</span></label>
                                        <input type="text" name="nip" value="{{ old('nip') }}" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                            placeholder="Nomor Induk Pegawai">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-600">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                        placeholder="email@beacukai.go.id">
                                </div>
                            </div>
                        </div>

                        <!-- Data Kepegawaian -->
                        <div>
                            <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Data Kepegawaian</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan <span class="text-red-600">*</span></label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                        placeholder="Jabatan/Posisi">
                                </div>
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Role <span class="text-red-600">*</span></label>
                                        <select name="role" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
                                            <option value="">-- Pilih Role --</option>
                                            <option value="pelaksana" {{ old('role') == 'pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                                            <option value="eselon_iv" {{ old('role') == 'eselon_iv' ? 'selected' : '' }}>Eselon IV</option>
                                            <option value="eselon_iii" {{ old('role') == 'eselon_iii' ? 'selected' : '' }}>Eselon III</option>
                                            <option value="eselon_ii" {{ old('role') == 'eselon_ii' ? 'selected' : '' }}>Eselon II</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kantor <span class="text-red-600">*</span></label>
                                        <select name="kantor_id" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
                                            <option value="">-- Pilih Kantor --</option>
                                            @foreach($kantorList as $kantor)
                                                <option value="{{ $kantor->id }}" {{ old('kantor_id') == $kantor->id ? 'selected' : '' }}>
                                                    {{ $kantor->nama_kantor }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keamanan Akun -->
                        <div>
                            <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Keamanan Akun</h3>
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-600">*</span></label>
                                    <input type="password" name="password" required
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                        placeholder="Minimal 6 karakter">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-600">*</span></label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                        placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full rounded-lg bg-navy px-4 py-3 text-base font-semibold text-white hover:bg-slate-950 focus:outline-none focus:ring-4 focus:ring-navy/20 transition-colors">
                            Daftar Sebagai Petugas
                        </button>
                    </form>
                </div>

                <div class="px-8 py-4 border-t border-slate-200 bg-slate-50 text-center">
                    <p class="text-sm text-slate-600">
                        Sudah memiliki akun petugas? 
                        <a href="{{ route('login.petugas.view') }}" class="font-semibold text-navy hover:text-gold transition-colors">Login di sini</a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-slate-500">
                <p>&copy; 2025 Direktorat Jenderal Bea dan Cukai. Platform E-Riset DJBC.</p>
            </div>
        </div>
    </div>
</body>
</html>
