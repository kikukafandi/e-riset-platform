<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas - Platform E-Riset DJBC</title>

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
    <div class="min-h-screen flex">
        <!-- Side Panel (Desktop) -->
        <div class="hidden lg:flex lg:w-2/5 bg-gradient-to-br from-navy via-slate-900 to-slate-950 text-white flex-col justify-center px-12">
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white text-navy font-bold text-lg">DJ</div>
                    <div>
                        <p class="text-xs font-semibold text-gold tracking-widest">DIREKTORAT JENDERAL</p>
                        <p class="text-lg font-bold leading-tight">Bea dan Cukai</p>
                    </div>
                </div>
                <h2 class="text-3xl font-bold mb-4">Platform E-Riset DJBC</h2>
                <p class="text-slate-300 leading-relaxed">Portal khusus petugas untuk mengelola permohonan riset secara efisien dan terintegrasi.</p>
            </div>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-gold flex-shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Manajemen Permohonan</p>
                        <p class="text-slate-400 text-sm">Kelola verifikasi dan persetujuan permohonan riset</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-gold flex-shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Dashboard Petugas</p>
                        <p class="text-slate-400 text-sm">Pantau statistik dan antrian permohonan</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-gold flex-shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Sistem Terintegrasi</p>
                        <p class="text-slate-400 text-sm">Akses penuh ke sistem manajemen riset DJBC</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <!-- Logo Mobile -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy text-white font-semibold">DJ</div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-gold tracking-wide">DIREKTORAT JENDERAL</p>
                            <p class="text-sm font-bold text-navy leading-tight">Bea dan Cukai</p>
                        </div>
                    </div>
                </div>

                <!-- Card -->
                <div class="bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-200 bg-slate-50">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy/10 text-navy">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-navy">Login Petugas</h1>
                                <p class="text-xs text-slate-600">Portal Manajemen E-Riset</p>
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

                        <form action="{{ route('login.petugas') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="inputEmail" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                <input type="email" id="inputEmail" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                    placeholder="email@beacukai.go.id">
                            </div>

                            <div>
                                <label for="inputPassword" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                                <input type="password" id="inputPassword" name="password" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20"
                                    placeholder="Masukkan password">
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="inputRememberPassword" name="remember"
                                    class="h-4 w-4 rounded border-slate-300 text-navy focus:ring-navy">
                                <label for="inputRememberPassword" class="ml-2 text-sm text-slate-600">Ingat saya</label>
                            </div>

                            <button type="submit"
                                class="w-full rounded-lg bg-navy px-4 py-3 text-base font-semibold text-white hover:bg-slate-950 focus:outline-none focus:ring-4 focus:ring-navy/20 transition-colors">
                                Masuk sebagai Petugas
                            </button>
                        </form>
                    </div>

                    <div class="px-8 py-4 border-t border-slate-200 bg-slate-50 text-center">
                        <p class="text-sm text-slate-600">
                            Belum memiliki akun petugas? 
                            <a href="{{ route('register.petugas.view') }}" class="font-semibold text-navy hover:text-gold transition-colors">Daftar di sini</a>
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-xs text-slate-500">
                    <p>&copy; 2025 Direktorat Jenderal Bea dan Cukai. Platform E-Riset DJBC.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
