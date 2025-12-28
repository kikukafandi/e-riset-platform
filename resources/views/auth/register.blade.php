<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Platform E-Riset DJBC</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet">

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

        .tab-button {
            position: relative;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: #64748b;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .tab-button:first-child {
            border-radius: 0.75rem 0 0 0;
        }

        .tab-button:last-child {
            border-radius: 0 0.75rem 0 0;
            border-left: none;
        }

        .tab-button:hover {
            background: #f1f5f9;
            color: #0F2A44;
            transform: translateY(-2px);
        }

        .tab-button.active {
            background: #0F2A44;
            color: white;
            border-color: #0F2A44;
            box-shadow: 0 4px 6px -1px rgba(15, 42, 68, 0.1), 0 2px 4px -1px rgba(15, 42, 68, 0.06);
        }

        .tab-button.active:hover {
            background: #0A1A2C;
            transform: none;
        }
    </style>
</head>

<body class="bg-slate-50">
    <div class="min-h-screen py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-navy text-white font-bold text-lg">
                        DJ</div>
                    <div class="text-left">
                        <p class="text-xs font-semibold text-gold tracking-wide">DIREKTORAT JENDERAL</p>
                        <p class="text-base font-bold text-navy leading-tight">Bea dan Cukai</p>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-navy mb-2">Registrasi Akun Pemohon</h1>
                <p class="text-slate-600">Platform E-Riset DJBC</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-slate-100">
                    <div class="flex">
                        <button type="button" onclick="switchTab('mahasiswa')" id="tab-mahasiswa"
                            class="tab-button active flex-1 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Mahasiswa</span>
                        </button>
                        <button type="button" onclick="switchTab('nonmahasiswa')" id="tab-nonmahasiswa"
                            class="tab-button flex-1 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Non Mahasiswa</span>
                        </button>
                    </div>
                    <div class="px-8 py-3 bg-white">
                        <p class="text-sm text-slate-600 text-center">
                            <span class="font-semibold text-navy">Pilih kategori pemohon</span> yang sesuai dengan
                            status Anda
                        </p>
                    </div>
                </div>

                <div class="px-8 py-8">
                    <div id="content-mahasiswa" class="tab-content">
                        <form action="{{ route('register') }}" method="post" class="space-y-6">
                            @csrf
                            <input type="hidden" name="kategori" value="mahasiswa">

                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Data
                                    Akun</h3>
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span
                                                class="text-red-600">*</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('email') border-red-500 @enderror"
                                            placeholder="nama@email.com">
                                        @error('email')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon
                                            <span class="text-red-600">*</span></label>
                                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('no_telepon') border-red-500 @enderror"
                                            placeholder="08xx-xxxx-xxxx">
                                        @error('no_telepon')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span
                                                class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <input type="password" id="passMhs" name="password" required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 pr-12 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('password') border-red-500 @enderror"
                                                placeholder="Minimal 6 karakter">
                                            <button type="button"
                                                onclick="toggleVisibility('passMhs', 'iconShowMhs', 'iconHideMhs')"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-navy focus:outline-none">
                                                <svg id="iconShowMhs" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="iconHideMhs" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi
                                            Password <span class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <input type="password" id="confMhs" name="password_confirmation"
                                                required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 pr-12 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                                placeholder="Ulangi password">
                                            <button type="button"
                                                onclick="toggleVisibility('confMhs', 'iconShowConfMhs', 'iconHideConfMhs')"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-navy focus:outline-none">
                                                <svg id="iconShowConfMhs" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="iconHideConfMhs" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Data
                                    Pemohon</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap
                                            <span class="text-red-600">*</span></label>
                                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                            required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('nama_lengkap') border-red-500 @enderror"
                                            placeholder="Nama lengkap sesuai KTP">
                                        @error('nama_lengkap')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor NIK
                                                <span class="text-red-600">*</span></label>
                                            <input type="text" name="nik" value="{{ old('nik') }}" required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('nik') border-red-500 @enderror"
                                                placeholder="16 digit NIK">
                                            @error('nik')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIM <span
                                                    class="text-red-600">*</span></label>
                                            <input type="text" name="nim" value="{{ old('nim') }}"
                                                required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('nim') border-red-500 @enderror"
                                                placeholder="Nomor Induk Mahasiswa">
                                            @error('nim')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat <span
                                                class="text-red-600">*</span></label>
                                        <textarea name="alamat" rows="3" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('alamat') border-red-500 @enderror"
                                            placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Universitas
                                                <span class="text-red-600">*</span></label>
                                            <input type="text" name="kampus" value="{{ old('kampus') }}"
                                                required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('kampus') border-red-500 @enderror"
                                                placeholder="Nama universitas">
                                            @error('kampus')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenjang
                                                Pendidikan <span class="text-red-600">*</span></label>
                                            <select name="jenjang" required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('jenjang') border-red-500 @enderror">
                                                <option value="">Pilih Jenjang</option>
                                                <option value="D1">D1</option>
                                                <option value="D2">D2</option>
                                                <option value="D3">D3</option>
                                                <option value="S1">D4/S1</option>
                                                <option value="S2">S2</option>
                                                <option value="S3">S3</option>
                                            </select>
                                            @error('jenjang')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jurusan <span
                                                class="text-red-600">*</span></label>
                                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('jurusan') border-red-500 @enderror"
                                            placeholder="Nama jurusan/program studi">
                                        @error('jurusan')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full rounded-lg bg-navy px-4 py-3 text-base font-semibold text-white hover:bg-slate-950 focus:outline-none focus:ring-4 focus:ring-navy/20 transition-colors">
                                Daftar Sebagai Mahasiswa
                            </button>
                        </form>
                    </div>

                    <div id="content-nonmahasiswa" class="tab-content hidden">
                        <form action="{{ route('register') }}" method="post" class="space-y-6">
                            @csrf
                            <input type="hidden" name="kategori" value="non-mahasiswa">

                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Data
                                    Akun</h3>
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span
                                                class="text-red-600">*</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('email') border-red-500 @enderror"
                                            placeholder="nama@email.com">
                                        @error('email')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon
                                            <span class="text-red-600">*</span></label>
                                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                                            required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('no_telepon') border-red-500 @enderror"
                                            placeholder="08xx-xxxx-xxxx">
                                        @error('no_telepon')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span
                                                class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <input type="password" id="passNon" name="password" required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 pr-12 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('password') border-red-500 @enderror"
                                                placeholder="Minimal 6 karakter">
                                            <button type="button"
                                                onclick="toggleVisibility('passNon', 'iconShowNon', 'iconHideNon')"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-navy focus:outline-none">
                                                <svg id="iconShowNon" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="iconHideNon" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi
                                            Password <span class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <input type="password" id="confNon" name="password_confirmation"
                                                required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 pr-12 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                                placeholder="Ulangi password">
                                            <button type="button"
                                                onclick="toggleVisibility('confNon', 'iconShowConfNon', 'iconHideConfNon')"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-navy focus:outline-none">
                                                <svg id="iconShowConfNon" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg id="iconHideConfNon" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4 pb-2 border-b border-slate-200">Data
                                    Pemohon</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap
                                            <span class="text-red-600">*</span></label>
                                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                            required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('nama_lengkap') border-red-500 @enderror"
                                            placeholder="Nama lengkap sesuai KTP">
                                        @error('nama_lengkap')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor NIK
                                                <span class="text-red-600">*</span></label>
                                            <input type="text" name="nik" value="{{ old('nik') }}"
                                                required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('nik') border-red-500 @enderror"
                                                placeholder="16 digit NIK">
                                            @error('nik')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status
                                                Kepegawaian</label>
                                            <select name="is_pegawai"
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
                                                <option value="">Pilih Status</option>
                                                <option value="ya"
                                                    {{ old('is_pegawai') == 'ya' ? 'selected' : '' }}>Pegawai Bea Cukai
                                                </option>
                                                <option value="tidak"
                                                    {{ old('is_pegawai') == 'tidak' ? 'selected' : '' }}>Bukan Pegawai
                                                    Bea Cukai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIP (maks 18
                                            digit)</label>
                                        <input type="text" name="npwp" value="{{ old('npwp') }}"
                                            inputmode="numeric" pattern="^[0-9]{1,18}$" maxlength="18"
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('npwp') border-red-500 @enderror"
                                            placeholder="Diisi jika Pegawai Bea Cukai">
                                        <p class="text-xs text-slate-500 mt-1">Diisi jika memilih Pegawai Bea Cukai</p>
                                        @error('npwp')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat <span
                                                class="text-red-600">*</span></label>
                                        <textarea name="alamat" rows="3" required
                                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('alamat') border-red-500 @enderror"
                                            placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Instansi
                                                <span class="text-red-600">*</span></label>
                                            <input type="text" name="instansi" value="{{ old('instansi') }}"
                                                required
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('instansi') border-red-500 @enderror"
                                                placeholder="Nama instansi/lembaga">
                                            @error('instansi')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Sponsor
                                                Riset</label>
                                            <input type="text" name="sponsor_riset"
                                                value="{{ old('sponsor_riset') }}"
                                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('sponsor_riset') border-red-500 @enderror"
                                                placeholder="Opsional">
                                            @error('sponsor_riset')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full rounded-lg bg-navy px-4 py-3 text-base font-semibold text-white hover:bg-slate-950 focus:outline-none focus:ring-4 focus:ring-navy/20 transition-colors">
                                Daftar Sebagai Non Mahasiswa
                            </button>
                        </form>
                    </div>
                </div>

                <div class="px-8 py-4 border-t border-slate-200 bg-slate-50 text-center">
                    <p class="text-sm text-slate-600">
                        Sudah memiliki akun?
                        <a href="{{ route('loginPage') }}"
                            class="font-semibold text-navy hover:text-gold transition-colors">Login di sini</a>
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center text-xs text-slate-500">
                <p>&copy; 2025 Direktorat Jenderal Bea dan Cukai. Platform E-Riset DJBC.</p>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-button').forEach(el => el.classList.remove('active'));

            // Show selected
            document.getElementById('content-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).classList.add('active');
        }

        // Toggle Password Logic
        function toggleVisibility(inputId, iconShowId, iconHideId) {
            const input = document.getElementById(inputId);
            const iconShow = document.getElementById(iconShowId);
            const iconHide = document.getElementById(iconHideId);

            if (input.type === 'password') {
                input.type = 'text';
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
